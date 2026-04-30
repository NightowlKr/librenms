<?php

namespace LibreNMS\Tests\Unit;

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

    public function testUnsupportedProtocolEnumNormalizesToSmallintValue(): void
    {
        $this->assertSame(32767, \alteon_enum_to_int('unsupported', [
            2147483647 => 'unsupported',
        ]));
    }
}
