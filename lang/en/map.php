<?php

return [
    'custom' => [
        'title' => [
            'edit_dialog' => 'Select Custom Map To Edit',
            'create' => 'Create New Custom Map',
            'view' => ':name | Custom Map',
            'edit' => 'Edit Custom Map',
            'manage' => 'Manage Custom Maps',
        ],
        'create_map' => 'New Map',
        'view' => [
            'loading' => 'Loading data',
            'no_devices' => 'No devices found',
        ],
        'nodeimage' => [
            'delete' => 'Delete Image',
            'upload' => 'Upload Image',
            'name' => 'Image Name',
            'new' => 'New Image',
            'title' => [
                'edit' => 'Edit Node Image',
                'manage' => 'Manage Node Images',
                'new' => 'New Node Image',
            ],
        ],
        'edit' => [
            'text_font' => 'Text Font',
            'text_size' => 'Text Size',
            'text_color' => 'Text Color',
            'defaults' => 'Set Defaults',
            'bg' => [
                'title' => 'Set Background',
                'background' => 'Background',
                'color' => 'Color',
                'image' => 'Image',
                'map' => 'Map',
                'none' => 'None',
                'clear_bg' => 'Clear BG',
                'clear_background' => 'Clear Background',
                'keep_background' => 'Keep Background',
                'saving' => 'Saving...',
                'save_errors' => 'Save failed due to the following errors:',
                'save_error' => 'Save failed.  Server returned error response code: :code',
                'save' => 'Save Background',
                'lat' => 'Latitude',
                'lng' => 'Longitude',
                'zoom' => 'Zoom',
                'adjust_map' => 'Adjust Map',
                'adjust_map_finish' => 'Done Adjusting Map',
                'as_image' => 'Set as Image',
                'as_image_hint' => 'Setting the map as an image background will be static, but have improved performance and work without connection to the map tile server',
            ],
            'map' => [
                'settings_title' => 'Map Settings',
                'selectall' => 'Select All',
                'name' => 'Name',
                'menu_group' => 'Menu Group',
                'multiselect_info' => 'Either long-click or hold down ctrl to select multiple nodes',
                'no_group' => 'No Group',
                'width' => 'Width',
                'height' => 'Height',
                'alignment' => 'Node Alignment',
                'edgeseparation' => 'Link Separation',
                'reverse' => 'Reverse Arrows',
                'saving' => 'Saving...',
                'save_errors' => 'Save failed due to the following errors:',
                'save_error' => 'Save failed.  Server returned error response code: :code',
                'clone' => 'Clone :name?',
                'delete' => 'Delete :name?',
                'list' => 'Return to map list',
                'unsavedchanges' => 'You have unsaved changes.  Press confirm to discard changes and return to the map list, or cancel to return to the editor.',
                'edit' => 'Edit Map Settings',
                'rerender' => 'Re-Render Map',
                'save' => 'Save Map',
                'legend' => [
                    'customcolours' => 'Custom Colours',
                    'colour' => 'Colour',
                    'colour_lower_pct' => 'Start Percent',
                    'colour_down' => 'Device Down Colour',
                    'colour_invalid' => 'Unknown Percent Colour',
                    'font_size' => 'Legend Text Size',
                    'steps' => 'Legend Steps',
                    'hideinvalid' => 'Hide Invalid',
                    'hideoverspeed' => 'Hide 100%+',
                ],
                'legend_title' => 'Legend Settings',
                'legend_toggle' => 'Toggle Legend',
                'zoom' => 'Pan and Zoom',
                'dragnodes' => 'Move Nodes',
                'physics' => 'Physics Engine',
            ],
            'node' => [
                'new' => 'New Node',
                'add' => 'Add Node',
                'edit' => 'Edit Node',
                'defaults_title' => 'Node Default Config',
                'label' => 'Label',
                'name' => 'Node Name',
                'device_select' => 'Select Device',
                'edit_defaults' => 'Edit Node Defaults',
                'map_link' => 'Link to Map',
                'map_select' => 'Select Map...',
                'style' => 'Style',
                'style_options' => [
                    'box' => 'Box',
                    'circle' => 'Circle',
                    'database' => 'Database',
                    'ellipse' => 'Ellipse',
                    'text' => 'Text',
                    'device_image' => 'Device Image',
                    'device_image_circle' => 'Device Image (Circular)',
                    'diamond' => 'Diamond',
                    'dot' => 'Dot',
                    'star' => 'Star',
                    'triangle' => 'Triangle',
                    'triangle_inverted' => 'Triangle Inverted',
                    'hexagon' => 'Hexagon',
                    'square' => 'Square',
                    'icon' => 'Icon (select below)',
                ],
                'icon' => 'Icon',
                'icon_options' => [
                    'server' => 'Server',
                    'desktop' => 'Desktop',
                    'dish' => 'Satellite Dish',
                    'satellite' => 'Satellite',
                    'wifi' => 'Wifi',
                    'cloud' => 'Cloud',
                    'globe' => 'Globe',
                    'tower' => 'Tower',
                    'arrow_right' => 'Arrow - Right',
                    'arrow_left' => 'Arrow - Left',
                    'arrow_up' => 'Arrow - Up',
                    'arrow_down' => 'Arrow - Down',
                ],
                'image' => 'Image',
                'image_options' => [
                    'adc' => 'Application Delivery Controller',
                    'firewall' => 'Firewall',
                    'gtm' => 'Global Traffic Manager',
                    'router' => 'Router',
                    'switch-l2' => 'Switch - L2',
                    'switch-l3' => 'Switch - L3',
                ],
                'size' => 'Node Size',
                'bg_color' => 'Background Color',
                'border_color' => 'Border Color',
            ],
            'edge' => [
                'new' => 'New Edge',
                'add' => 'Add Edge',
                'edit' => 'Edit Edge',
                'defaults_title' => 'Edge Default Config',
                'dynamic_width' => 'Dynamic Width',
                'fixed_width' => 'Fixed Width',
                'from' => 'From',
                'to' => 'To',
                'port_select' => 'Select Port',
                'reverse' => 'Reverse Port Direction',
                'edit_defaults' => 'Edit Edge Defaults',
                'style' => 'Line Style',
                'style_options' => [
                    'dynamic' => 'Dynamic',
                    'continuous' => 'Continuous',
                    'discrete' => 'Discrete',
                    'diagonalCross' => 'Diagonal Cross',
                    'straightCross' => 'Straight Cross',
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                    'curvedCW' => 'Curved Clockwise',
                    'curvedCCW' => 'Curved Counter Clockwise',
                    'cubicBezier' => 'Cubic Bezier',
                ],
                'show_usage_percent' => 'Show percent usage',
                'show_usage_bps' => 'Show bps usage',
                'text_align' => 'Text Alignment',
                'align_options' => [
                    'horizontal' => 'Horizontal',
                    'top' => 'Top',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                ],
                'label' => 'Label',
                'recenter' => 'Recenter Line',
            ],
            'validate' => [
                'width_format' => 'Width must be a number followed by px or %',
                'width_percent' => 'Width percent must be between 10 and 100',
                'width_pixels' => 'Width in pixels must be at least 200',
                'height_format' => 'Height must be a number followed by px or %',
                'height_percent' => 'Height percent must be between 10 and 100',
                'height_pixels' => 'Height in pixels must be at least 200',
            ],
        ],
        'widget' => [
            'not_found' => 'No map selected.  Edit widget to select map.',
        ],
    ],
];