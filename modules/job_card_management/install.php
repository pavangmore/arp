// modules/job_card_management/install.php
register_activation_hook('job_card_management', function() {
    $CI = &get_instance();
    
    // Create version tracking table if it doesn't exist
    if (!$CI->db->table_exists(db_prefix().'job_card_versions')) {
        $CI->db->query("CREATE TABLE ".db_prefix()."job_card_versions (
            id INT(11) NOT NULL AUTO_INCREMENT,
            version VARCHAR(20) NOT NULL,
            date_installed DATETIME NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    
    // Get current installed version
    $current_version = get_option('job_card_management_version');
    
    // If fresh install
    if (!$current_version) {
        $this->install_initial_version();
        $current_version = '1.0.0';
    }
    
    // Run upgrades based on current version
    if (version_compare($current_version, '1.1.0', '<')) {
        $this->upgrade_to_1_1_0();
    }
    
    if (version_compare($current_version, '1.2.0', '<')) {
        $this->upgrade_to_1_2_0();
    }
    
    // Update version in database
    update_option('job_card_management_version', '1.2.0');
});

function install_initial_version() {
    $CI = &get_instance();
    
    $CI->db->query("CREATE TABLE ".db_prefix()."job_cards (
        id INT(11) NOT NULL AUTO_INCREMENT,
        client_id INT(11) NOT NULL,
        vehicle_number VARCHAR(50) NOT NULL,
        date_in DATETIME NOT NULL,
        status VARCHAR(20) DEFAULT 'pending',
        PRIMARY KEY (id)
    )");
}

function upgrade_to_1_1_0() {
    $CI = &get_instance();
    
    // Add new columns
    $CI->db->query("ALTER TABLE ".db_prefix()."job_cards 
        ADD COLUMN date_out DATETIME NULL AFTER date_in,
        ADD COLUMN description TEXT NULL AFTER status");
        
    // Add new status
    $CI->db->query("ALTER TABLE ".db_prefix()."job_cards 
        MODIFY COLUMN status VARCHAR(20) DEFAULT 'pending'");
        
    // Record this upgrade
    $CI->db->insert(db_prefix().'job_card_versions', [
        'version' => '1.1.0',
        'date_installed' => date('Y-m-d H:i:s')
    ]);
}

function upgrade_to_1_2_0() {
    $CI = &get_instance();
    
    // Add created_by tracking
    $CI->db->query("ALTER TABLE ".db_prefix()."job_cards 
        ADD COLUMN created_by INT(11) NOT NULL AFTER description");
        
    // Add index for better performance
    $CI->db->query("ALTER TABLE ".db_prefix()."job_cards 
        ADD INDEX client_id_index (client_id)");
        
    // Record this upgrade
    $CI->db->insert(db_prefix().'job_card_versions', [
        'version' => '1.2.0',
        'date_installed' => date('Y-m-d H:i:s')
    ]);
}



// modules/job_card_management/install.php
register_activation_hook('job_card_management', function() {
    $CI = &get_instance();

    // Add admin menu item
    $CI->app_menu->add_sidebar_menu_item('job_card_management', [
        'name'     => _l('job_cards'),
        'href'     => admin_url('job_card_management/manage'),
        'icon'     => 'fa fa-file-text-o',
        'position' => 15
    ]);

    // Add child menu items if needed
    $CI->app_menu->add_sidebar_children_item('job_card_management', [
        'slug'     => 'job_cards_list',
        'name'     => _l('job_cards_list'),
        'href'     => admin_url('job_card_management/manage'),
        'position' => 1
    ]);

    $CI->app_menu->add_sidebar_children_item('job_card_management', [
        'slug'     => 'new_job_card',
        'name'     => _l('new_job_card'),
        'href'     => admin_url('job_card_management/save'),
        'position' => 2
    ]);
});


// Add to your install.php
$CI->db->insert(db_prefix().'permissions', [
    'name' => 'Job Cards',
    'shortname' => 'job_cards',
    'group' => 'modules'
]);

// Add view, create, edit permissions
$CI->db->insert_batch(db_prefix().'permissions', [
    ['name' => 'View Job Cards', 'shortname' => 'job_cards_view', 'group' => 'modules'],
    ['name' => 'Create Job Cards', 'shortname' => 'job_cards_create', 'group' => 'modules'],
    ['name' => 'Edit Job Cards', 'shortname' => 'job_cards_edit', 'group' => 'modules'],
    ['name' => 'Delete Job Cards', 'shortname' => 'job_cards_delete', 'group' => 'modules']
]);
