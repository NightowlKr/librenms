<?php

namespace LibreNMS\Tests\Unit;

use App\Models\Device;
use DeviceCache;
use LibreNMS\Data\Source\Snmp\SnmpQueryInterface;
use LibreNMS\Data\Source\SnmpQueryInterface as LegacySnmpQueryInterface;
use LibreNMS\Tests\TestCase;

final class AlteonSnmpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        require_once base_path('includes/common/alteon-snmp.inc.php');
    }

    public function testVirtualServiceProtocolHandlesUnsupportedValues(): void
    {
        $this->assertSame('UDP', \alteon_virtual_service_protocol(2));
        $this->assertSame('UNSUPPORTED', \alteon_virtual_service_protocol(2147483647));
        $this->assertSame('UNSUPPORTED', \alteon_virtual_service_protocol(32767));
        $this->assertSame('UNKNOWN', \alteon_virtual_service_protocol(1));
    }

    public function testAlteonSnmpUsesCurrentSnmpQueryDeviceApi(): void
    {
        $device = new Device;
        $device->device_id = 424242;
        DeviceCache::fake($device);
        $primary = new Device;
        $primary->device_id = 424240;
        DeviceCache::fake($primary);
        DeviceCache::setPrimary($primary->device_id);

        $interface = interface_exists(SnmpQueryInterface::class) ? SnmpQueryInterface::class : LegacySnmpQueryInterface::class;
        $query = \alteon_snmp(['device_id' => $device->device_id]);
        $this->assertInstanceOf($interface, $query);
        $this->assertSame($device, (new \ReflectionProperty($query, 'device'))->getValue($query));
    }

    public function testAlteonSnmpDefaultsToPrimaryDevice(): void
    {
        $device = new Device;
        $device->device_id = 424243;
        DeviceCache::fake($device);
        DeviceCache::setPrimary($device->device_id);

        $interface = interface_exists(SnmpQueryInterface::class) ? SnmpQueryInterface::class : LegacySnmpQueryInterface::class;
        $query = \alteon_snmp([]);
        $this->assertInstanceOf($interface, $query);
        $this->assertSame($device, (new \ReflectionProperty($query, 'device'))->getValue($query));
    }

    public function testAlteonWalkHelpersNormalizeMibPrefixes(): void
    {
        $query = $this->mockAlteonQuery();
        $responseClass = class_exists(\LibreNMS\Data\Source\Snmp\SnmpResponse::class)
            ? \LibreNMS\Data\Source\Snmp\SnmpResponse::class
            : \LibreNMS\Data\Source\SnmpResponse::class;
        $response = \Mockery::mock($responseClass);
        $query->shouldReceive('walk')->with('serverEntry')->once()->andReturn($response);
        $response->shouldReceive('valuesByIndex')->once()->andReturn([
            1 => ['ALTEON-CHEETAH-LAYER4-MIB::serverFailures' => '7'],
        ]);
        $this->assertSame([1 => ['serverFailures' => '7']], \alteon_walk_table([], 'serverEntry'));

        $query->shouldReceive('walk')->with('groupMemberEntry')->once()->andReturn($response);
        $response->shouldReceive('table')->with(2)->once()->andReturn([
            2 => [1 => ['ALTEON-CHEETAH-LAYER4-MIB::memberState' => '1']],
        ]);
        $this->assertSame([2 => [1 => ['memberState' => '1']]], \alteon_walk_twopart([], 'groupMemberEntry'));
    }

    public function testAlteonGetPreservesZeroAndRejectsMissingValues(): void
    {
        $query = $this->mockAlteonQuery();
        $responseClass = class_exists(\LibreNMS\Data\Source\Snmp\SnmpResponse::class)
            ? \LibreNMS\Data\Source\Snmp\SnmpResponse::class
            : \LibreNMS\Data\Source\SnmpResponse::class;
        $response = \Mockery::mock($responseClass);
        $query->shouldReceive('get')->with('sensor.0')->times(3)->andReturn($response);
        $response->shouldReceive('value')->times(3)->andReturn('0', '', 'No Such Instance');

        $this->assertSame('0', \alteon_snmp_get([], 'sensor.0'));
        $this->assertFalse(\alteon_snmp_get([], 'sensor.0'));
        $this->assertFalse(\alteon_snmp_get([], 'sensor.0'));
    }

    public function testCountPollingAggregatesRealServerFailuresByGroup(): void
    {
        $query = $this->mockAlteonQuery();
        $responseClass = class_exists(\LibreNMS\Data\Source\Snmp\SnmpResponse::class)
            ? \LibreNMS\Data\Source\Snmp\SnmpResponse::class
            : \LibreNMS\Data\Source\SnmpResponse::class;
        $members = \Mockery::mock($responseClass);
        $query->shouldReceive('walk')->with('ALTEON-CHEETAH-LAYER4-MIB::slbCurCfgEnhGroupRealServerEntry')
            ->once()->andReturn($members);
        $members->shouldReceive('table')->with(2)->once()->andReturn([
            1 => [10 => [], 20 => []],
            2 => [20 => []],
        ]);
        $failures = \Mockery::mock($responseClass);
        $query->shouldReceive('walk')->with('ALTEON-CHEETAH-LAYER4-MIB::slbStatEnhRServerEntry')
            ->once()->andReturn($failures);
        $failures->shouldReceive('valuesByIndex')->once()->andReturn([
            10 => ['ALTEON-CHEETAH-LAYER4-MIB::slbStatEnhRServerFailures' => '3'],
            20 => ['ALTEON-CHEETAH-LAYER4-MIB::slbStatEnhRServerFailures' => '7'],
        ]);

        // Load the guarded polling functions before exercising the sensor branch.
        $sensor = ['sensor_type' => ''];
        $device = [];
        include base_path('includes/polling/sensors/count/alteonos.inc.php');

        $sensor = ['sensor_type' => 'alteonSlbGroupFailures', 'sensor_index' => '1'];
        include base_path('includes/polling/sensors/count/alteonos.inc.php');
        $this->assertSame(10, $sensor_value);

        $sensor['sensor_index'] = '2';
        include base_path('includes/polling/sensors/count/alteonos.inc.php');
        $this->assertSame(7, $sensor_value);
    }

    private function mockAlteonQuery(): \Mockery\MockInterface
    {
        $interface = interface_exists(SnmpQueryInterface::class) ? SnmpQueryInterface::class : LegacySnmpQueryInterface::class;
        $query = \Mockery::mock($interface);
        \SnmpQuery::shouldReceive('cache')->andReturn($query);
        $query->shouldReceive('mibDir')->with('alteonos')->andReturnSelf();
        $query->shouldReceive('mibDir')->with('radware')->andReturnSelf();
        $query->shouldReceive('mibDir')->with('nortel')->andReturnSelf();
        $query->shouldReceive('mibs')->with([
            'ALTEON-CHEETAH-LAYER4-Nortel-MIB',
            'ALTEON-CHEETAH-LAYER4-Radware-MIB',
            'ALTEON-CHEETAH-LAYER4-MIB',
            'ALTEON-CHEETAH-SWITCH-MIB',
            'ALTEON-ROOT-MIB',
        ])->andReturnSelf();

        return $query;
    }

    public function testUnsupportedProtocolEnumNormalizesToSmallintValue(): void
    {
        $this->assertSame(32767, \alteon_enum_to_int('unsupported', [
            2147483647 => 'unsupported',
        ]));
    }
}
