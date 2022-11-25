<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('Asia/Kolkata');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => '10.10.2.32',
          'port' => '3306',
          'username' => 'root',
          'password' => 'a1a1A!A!',
          'database' => 'dcapp',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return false;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return 'DataCentre Management Systems';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'Dashboard', 'description' => '');
    $result[] = array('caption' => 'Masters', 'description' => '');
    $result[] = array('caption' => 'Business', 'description' => '');
    $result[] = array('caption' => 'Infra', 'description' => '');
    $result[] = array('caption' => 'Load Balancer', 'description' => '');
    $result[] = array('caption' => 'Network', 'description' => '');
    $result[] = array('caption' => 'Service', 'description' => '');
    $result[] = array('caption' => 'Backup', 'description' => '');
    $result[] = array('caption' => 'Reports', 'description' => '');
    $result[] = array('caption' => 'Default', 'description' => '');
    $result[] = array('caption' => 'ISO / Records', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Dashboard', 'short_caption' => 'Dashboard', 'filename' => 'Dashboard.php', 'name' => 'Dashboard', 'group_name' => 'Dashboard', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Organization', 'short_caption' => 'Organization', 'filename' => 'organization.php', 'name' => 'organization', 'group_name' => 'Business', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => '  -Contact Person', 'short_caption' => '  -Contact Person', 'filename' => 'contact_person.php', 'name' => 'contact_person', 'group_name' => 'Business', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => '  --Contact Details', 'short_caption' => '  --Contact Details', 'filename' => 'contact_details.php', 'name' => 'contact_details', 'group_name' => 'Business', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Project', 'short_caption' => 'Project', 'filename' => 'project.php', 'name' => 'project', 'group_name' => 'Business', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => '  -Project App', 'short_caption' => '  -Project App', 'filename' => 'project_app.php', 'name' => 'project_app', 'group_name' => 'Business', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Work Order', 'short_caption' => 'Work Order', 'filename' => 'bd_work_order.php', 'name' => 'bd_work_order', 'group_name' => 'Business', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => '  - Work Order Doc', 'short_caption' => '  - Work Order Doc', 'filename' => 'bd_work_order_doc.php', 'name' => 'bd_work_order_doc', 'group_name' => 'Business', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => '  - Work Order Details', 'short_caption' => '  - Work Order Details', 'filename' => 'bd_work_order_details.php', 'name' => 'bd_work_order_details', 'group_name' => 'Business', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Service Initiation', 'short_caption' => 'Service Initiation', 'filename' => 'sw_service_id.php', 'name' => 'sw_service_id', 'group_name' => 'Business', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => ' - Expired Projects', 'short_caption' => ' - Expired Projects', 'filename' => 'rpt_bd_expired_Projects.php', 'name' => 'rpt_bd_expired_Projects', 'group_name' => 'Business', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => ' - Expiring Projects (Next 3 Months)', 'short_caption' => ' - Expiring Projects', 'filename' => 'rpt_bd_expiring_Projects.php', 'name' => 'rpt_bd_expiring_Projects', 'group_name' => 'Business', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Escalation Matrix', 'short_caption' => ' Escalation Matrix', 'filename' => 'bd_escalation_matrix.php', 'name' => 'bd_escalation_matrix', 'group_name' => 'Business', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Po Details', 'short_caption' => 'Po Details', 'filename' => 'po_details.php', 'name' => 'po_details', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Hw Details', 'short_caption' => 'Hw Details', 'filename' => 'hw_details.php', 'name' => 'hw_details', 'group_name' => 'Infra', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => ' - Hw Harddisk', 'short_caption' => ' - Hw Harddisk', 'filename' => 'hw_harddisk.php', 'name' => 'hw_harddisk', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - Hw Ram', 'short_caption' => ' - Hw Ram', 'filename' => 'hw_ram.php', 'name' => 'hw_ram', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - Hw Nw Port', 'short_caption' => ' - Hw Nw Port', 'filename' => 'hw_nw_port.php', 'name' => 'hw_nw_port', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - Hw Fc', 'short_caption' => ' - Hw Fc', 'filename' => 'hw_fc.php', 'name' => 'hw_fc', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - Hw Amc', 'short_caption' => ' - Hw Amc', 'filename' => 'hw_amc.php', 'name' => 'hw_amc', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Report: Infra Details', 'short_caption' => 'Report: Infra Details', 'filename' => 'rpt_infra_details.php', 'name' => 'rpt_infra_details', 'group_name' => 'Infra', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Report: AMC', 'short_caption' => 'Report: AMC', 'filename' => 'vw_AMC.php', 'name' => 'vw_AMC', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Infra Details', 'short_caption' => 'Infra Details', 'filename' => 'sw_infra_details.php', 'name' => 'sw_infra_details', 'group_name' => 'Infra', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => ' - Infra Users', 'short_caption' => ' - Infra Users', 'filename' => 'sw_infra_users.php', 'name' => 'sw_infra_users', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - Infra Software Installed', 'short_caption' => ' - Infra Software Installed', 'filename' => 'sw_infra_software_installed.php', 'name' => 'sw_infra_software_installed', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Software Details', 'short_caption' => 'Software Details', 'filename' => 'sw_software_details.php', 'name' => 'sw_software_details', 'group_name' => 'Infra', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => ' - Software Licence Keys', 'short_caption' => ' - Software Licence Keys', 'filename' => 'sw_software_licence_keys.php', 'name' => 'sw_software_licence_keys', 'group_name' => 'Infra', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Report: Load Balancer', 'short_caption' => 'Report: Load Balancer', 'filename' => 'rpt_loadbalancer.php', 'name' => 'rpt_loadbalancer', 'group_name' => 'Load Balancer', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'URL', 'short_caption' => 'URL', 'filename' => 'sw_url_ip.php', 'name' => 'sw_url_ip', 'group_name' => 'Load Balancer', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Virtual Server', 'short_caption' => 'Virtual Server', 'filename' => 'sw_lb_virtualserver.php', 'name' => 'sw_lb_virtualserver', 'group_name' => 'Load Balancer', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Pool', 'short_caption' => 'Pool', 'filename' => 'sw_lb_pool.php', 'name' => 'sw_lb_pool', 'group_name' => 'Load Balancer', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Virtual Server Pool Mapping', 'short_caption' => 'Virtual Server Pool Mapping', 'filename' => 'sw_lb_vs_pool.php', 'name' => 'sw_lb_vs_pool', 'group_name' => 'Load Balancer', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'App Rules', 'short_caption' => 'App Rules', 'filename' => 'sw_lb_app_rules.php', 'name' => 'sw_lb_app_rules', 'group_name' => 'Load Balancer', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Monitor', 'short_caption' => 'Monitor', 'filename' => 'sw_lb_app_monitor.php', 'name' => 'sw_lb_app_monitor', 'group_name' => 'Load Balancer', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Ip Subnet', 'short_caption' => 'Ip Subnet', 'filename' => 'nw_ip_subnet.php', 'name' => 'nw_ip_subnet', 'group_name' => 'Network', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => ' - Vlan Details', 'short_caption' => ' - Vlan Details', 'filename' => 'nw_vlan_details.php', 'name' => 'nw_vlan_details', 'group_name' => 'Network', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - Ip Infra', 'short_caption' => ' - Ip Infra', 'filename' => 'nw_ip_cdac_id.php', 'name' => 'nw_ip_infra', 'group_name' => 'Network', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - NAT List', 'short_caption' => ' - NAT List', 'filename' => 'nw_NAT_List.php', 'name' => 'nw_NAT_List', 'group_name' => 'Network', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Service Details', 'short_caption' => 'Service Details', 'filename' => 'sw_service_details.php', 'name' => 'sw_service_details', 'group_name' => 'Service', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => ' - Service Users', 'short_caption' => ' - Service Users', 'filename' => 'sw_service_users.php', 'name' => 'sw_service_users', 'group_name' => 'Service', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => ' - Service Links', 'short_caption' => ' - Service Links', 'filename' => 'sw_service_links.php', 'name' => 'sw_service_links', 'group_name' => 'Service', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Backup Details', 'short_caption' => 'Backup Details', 'filename' => 'backup_details.php', 'name' => 'backup_details', 'group_name' => 'Backup', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => '  -Report: Backup Scheduled', 'short_caption' => '  -Report: Backup Scheduled', 'filename' => 'rpt_bkp_scheduled.php', 'name' => 'rpt_bkp_scheduled', 'group_name' => 'Backup', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => '  -Report: Backup Not Scheduled', 'short_caption' => '  -Report: Backup Not Scheduled', 'filename' => 'rpt_bkp_not_scheduled_prd.php', 'name' => 'rpt_bkp_not_scheduled_prd', 'group_name' => 'Backup', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => '  -Backup Deactivation Details', 'short_caption' => '  -Backup Deactivation Details', 'filename' => 'backup_deactivation.php', 'name' => 'backup_deactivation', 'group_name' => 'Backup', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Off Hour Work Details', 'short_caption' => 'Off Hour Work Details', 'filename' => 'offHour_work_details.php', 'name' => 'offhour_work_details', 'group_name' => 'Reports', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Downtime', 'short_caption' => 'Downtime', 'filename' => 'sw_downtime_rp.php', 'name' => 'sw_downtime_rp', 'group_name' => 'Reports', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Report: Free Hardware Cdacn', 'short_caption' => 'Report: Free Hardware Cdacn', 'filename' => 'rpt_free_hardware_cdacn.php', 'name' => 'rpt_free_hardware_cdacn', 'group_name' => 'Reports', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Harware Life', 'short_caption' => 'Harware Life', 'filename' => 'rpt_hw_life.php', 'name' => 'rpt_hw_life', 'group_name' => 'Reports', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Printing Forms', 'short_caption' => 'Printing Forms', 'filename' => 'printing_forms.php', 'name' => 'printing_forms', 'group_name' => 'Masters', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Mst Org Type', 'short_caption' => 'Mst Org Type', 'filename' => 'mst_org_type.php', 'name' => 'mst_org_type', 'group_name' => 'Masters', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Mst Team', 'short_caption' => 'Mst Team', 'filename' => 'mst_team.php', 'name' => 'mst_team', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Department', 'short_caption' => 'Mst Department', 'filename' => 'mst_department.php', 'name' => 'mst_department', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Item Type', 'short_caption' => 'Mst Item Type', 'filename' => 'mst_item_type.php', 'name' => 'mst_item_type', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Size In', 'short_caption' => 'Mst Size In', 'filename' => 'mst_size_in.php', 'name' => 'mst_size_in', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Cpu', 'short_caption' => 'Mst Hw Cpu', 'filename' => 'mst_hw_cpu.php', 'name' => 'mst_hw_cpu', 'group_name' => 'Masters', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Harddisk', 'short_caption' => 'Mst Hw Harddisk', 'filename' => 'mst_hw_harddisk.php', 'name' => 'mst_hw_harddisk', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Ram Type', 'short_caption' => 'Mst Hw Ram Type', 'filename' => 'mst_hw_ram_type.php', 'name' => 'mst_hw_ram_type', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Make Model', 'short_caption' => 'Mst Hw Make Model', 'filename' => 'mst_hw_make_model.php', 'name' => 'mst_hw_make_model', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Raid Controller', 'short_caption' => 'Mst Hw Raid Controller', 'filename' => 'mst_hw_raid_controller.php', 'name' => 'mst_hw_raid_controller', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Speed', 'short_caption' => 'Mst Hw Speed', 'filename' => 'mst_hw_speed.php', 'name' => 'mst_hw_speed', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Power Supply', 'short_caption' => 'Mst Hw Power Supply', 'filename' => 'mst_hw_power_supply.php', 'name' => 'mst_hw_power_supply', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Hw Status', 'short_caption' => 'Mst Hw Status', 'filename' => 'mst_hw_status.php', 'name' => 'mst_hw_status', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Nw Aclname', 'short_caption' => 'Mst Nw Aclname', 'filename' => 'mst_nw_aclname.php', 'name' => 'mst_nw_aclname', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Nw Actions', 'short_caption' => 'Mst Nw Actions', 'filename' => 'mst_nw_actions.php', 'name' => 'mst_nw_actions', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Nw Context', 'short_caption' => 'Mst Nw Context', 'filename' => 'mst_nw_context.php', 'name' => 'mst_nw_context', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Sw Service Mapping', 'short_caption' => 'Mst Sw Service Mapping', 'filename' => 'mst_sw_service_mapping.php', 'name' => 'mst_sw_service_mapping', 'group_name' => 'Masters', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Mst Sw Service Name', 'short_caption' => 'Mst Sw Service Name', 'filename' => 'mst_sw_service_name.php', 'name' => 'mst_sw_service_name', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Sw Service Type', 'short_caption' => 'Mst Sw Service Type', 'filename' => 'mst_sw_service_type.php', 'name' => 'mst_sw_service_type', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Sw Software Name', 'short_caption' => 'Mst Sw Software Name', 'filename' => 'mst_sw_software_name.php', 'name' => 'mst_sw_software_name', 'group_name' => 'Masters', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Mst Sw Software Type', 'short_caption' => 'Mst Sw Software Type', 'filename' => 'mst_sw_software_type.php', 'name' => 'mst_sw_software_type', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Sw Lic Type', 'short_caption' => 'Mst Sw Lic Type', 'filename' => 'mst_sw_lic_type.php', 'name' => 'mst_sw_lic_type', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Application Name', 'short_caption' => 'Mst Application Name', 'filename' => 'mst_application_name.php', 'name' => 'mst_application_name', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Issues', 'short_caption' => 'Mst Issues', 'filename' => 'mst_issues.php', 'name' => 'mst_issues', 'group_name' => 'Masters', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Mst Nw Ports', 'short_caption' => 'Mst Nw Ports', 'filename' => 'mst_nw_ports.php', 'name' => 'mst_nw_ports', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Others', 'short_caption' => 'Mst Others', 'filename' => 'mst_others.php', 'name' => 'mst_others', 'group_name' => 'Masters', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Hardware Project Details', 'short_caption' => 'Hardware Project Details', 'filename' => 'rpt_hardware_project_details.php', 'name' => 'rpt_hardware_project_details', 'group_name' => 'Reports', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Internal Change Mgmt', 'short_caption' => 'Internal Change Mgmt', 'filename' => 'iso_internal_change_mgmt.php', 'name' => 'iso_internal_change_mgmt', 'group_name' => 'ISO / Records', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Hardware IN/OUT', 'short_caption' => 'Hardware IN/OUT', 'filename' => 'hw_inout.php', 'name' => 'hw_inout', 'group_name' => 'ISO / Records', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Rec Access Rights', 'short_caption' => 'Rec Access Rights', 'filename' => 'rec_access_rights.php', 'name' => 'rec_access_rights', 'group_name' => 'ISO / Records', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'VM Resources Summary', 'short_caption' => 'VM Resources Summary', 'filename' => 'rpt_vm_resources_summary.php', 'name' => 'rpt_vm_resources_summary', 'group_name' => 'Reports', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'VM Summary 5 Years Report', 'short_caption' => 'VM Summary 5 Years Report', 'filename' => 'rpt_vm_summary.php', 'name' => 'rpt_vm_summary', 'group_name' => 'Reports', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Escalation Matrix', 'short_caption' => 'Escalation Matrix', 'filename' => 'Escalation_Matrix.php', 'name' => 'Escalation_Matrix', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Mst Sw Lb Pool', 'short_caption' => 'Mst Sw Lb Pool', 'filename' => 'mst_sw_lb_pool.php', 'name' => 'mst_sw_lb_pool', 'group_name' => 'Masters', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '<b>DCMS</b>';
}

function GetPagesFooter()
{
    return
        'Copyright (c) CDAC Noida ( Data Centre )';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(true);
    $page->setShowNavigation(true);
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_AddEnvironmentVariablesHandler(&$variables)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetPageListType()
{
    return PageList::TYPE_MENU;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 32400;
}

function GetMailer()
{
    $smtpOptions = new SMTPOptions('10.226.1.99', 25, true, 'idc', 'I@@dc9921', '');
    $mailerOptions = new MailerOptions(MailerType::SMTP, 'idc@dcservices.in', 'IDC', $smtpOptions);
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MySqlIConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

/**
 * @param string $pageName
 * @return IPermissionSet
 */
function GetCurrentUserPermissionsForPage($pageName) 
{
    return GetApplication()->GetCurrentUserPermissionSet($pageName);
}
