<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class bd_work_order_bd_work_order_detailsPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Bd Work Order Details');
            $this->SetMenuLabel('Bd Work Order Details');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order_details`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('WO_Project', true),
                    new IntegerField('Service_Name'),
                    new IntegerField('Service_Type'),
                    new StringField('RateList(Year)'),
                    new IntegerField('Annual_Cost(excl-Dis)'),
                    new IntegerField('Annual_Cost(incl-Dis)'),
                    new IntegerField('vCPU'),
                    new IntegerField('RAM(GB)'),
                    new IntegerField('HDD(GB)'),
                    new IntegerField('VM_Mgmt_Cost'),
                    new IntegerField('Backup(GB)'),
                    new IntegerField('Backup(Nodes)'),
                    new StringField('Manpower'),
                    new IntegerField('Data(GB_monthly)'),
                    new IntegerField('Email_IDs'),
                    new IntegerField('Email_Space(GB)'),
                    new IntegerField('Rack_Space'),
                    new StringField('Rack_Power'),
                    new IntegerField('Bandwidth(Mbps)'),
                    new IntegerField('DB_license'),
                    new IntegerField('OT_Install_Cost'),
                    new IntegerField('Business_Support(%)'),
                    new IntegerField('Business_Support_Cost'),
                    new StringField('Remarks')
                )
            );
            $this->dataset->AddLookupField('WO_Project', 'bd_work_order', new IntegerField('id'), new IntegerField('Project', false, false, false, false, 'WO_Project_Project', 'WO_Project_Project_bd_work_order'), 'WO_Project_Project_bd_work_order');
            $this->dataset->AddLookupField('Service_Name', 'mst_sw_service_name', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Service_Name_Name', 'Service_Name_Name_mst_sw_service_name'), 'Service_Name_Name_mst_sw_service_name');
            $this->dataset->AddLookupField('Service_Type', 'mst_others', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Service_Type_Name', 'Service_Type_Name_mst_others'), 'Service_Type_Name_mst_others');
            $this->dataset->AddLookupField('RateList(Year)', 'mst_others', new IntegerField('id'), new StringField('Name', false, false, false, false, 'RateList(Year)_Name', 'RateList(Year)_Name_mst_others'), 'RateList(Year)_Name_mst_others');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'WO_Project', 'WO_Project_Project', 'WO Project'),
                new FilterColumn($this->dataset, 'Service_Name', 'Service_Name_Name', 'Service Name'),
                new FilterColumn($this->dataset, 'Service_Type', 'Service_Type_Name', 'Service Type'),
                new FilterColumn($this->dataset, 'RateList(Year)', 'RateList(Year)_Name', 'Rate List(Year)'),
                new FilterColumn($this->dataset, 'Annual_Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', 'Annual Cost(excl-Dis)'),
                new FilterColumn($this->dataset, 'Annual_Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', 'Annual Cost(incl-Dis)'),
                new FilterColumn($this->dataset, 'vCPU', 'vCPU', 'VCPU'),
                new FilterColumn($this->dataset, 'RAM(GB)', 'RAM(GB)', 'RAM(GB)'),
                new FilterColumn($this->dataset, 'HDD(GB)', 'HDD(GB)', 'HDD(GB)'),
                new FilterColumn($this->dataset, 'VM_Mgmt_Cost', 'VM_Mgmt_Cost', 'VM Mgmt Cost'),
                new FilterColumn($this->dataset, 'Backup(GB)', 'Backup(GB)', 'Backup(GB)'),
                new FilterColumn($this->dataset, 'Backup(Nodes)', 'Backup(Nodes)', 'Backup(Nodes)'),
                new FilterColumn($this->dataset, 'Manpower', 'Manpower', 'Manpower'),
                new FilterColumn($this->dataset, 'Data(GB_monthly)', 'Data(GB_monthly)', 'Data(GB Monthly)'),
                new FilterColumn($this->dataset, 'Email_IDs', 'Email_IDs', 'Email IDs'),
                new FilterColumn($this->dataset, 'Email_Space(GB)', 'Email_Space(GB)', 'Email Space(GB)'),
                new FilterColumn($this->dataset, 'Rack_Space', 'Rack_Space', 'Rack Space'),
                new FilterColumn($this->dataset, 'Rack_Power', 'Rack_Power', 'Rack Power'),
                new FilterColumn($this->dataset, 'Bandwidth(Mbps)', 'Bandwidth(Mbps)', 'Bandwidth(Mbps)'),
                new FilterColumn($this->dataset, 'DB_license', 'DB_license', 'DB License'),
                new FilterColumn($this->dataset, 'OT_Install_Cost', 'OT_Install_Cost', 'OT Install Cost'),
                new FilterColumn($this->dataset, 'Business_Support(%)', 'Business_Support(%)', 'Business Support(%)'),
                new FilterColumn($this->dataset, 'Business_Support_Cost', 'Business_Support_Cost', 'Business Support Cost'),
                new FilterColumn($this->dataset, 'Remarks', 'Remarks', 'Remarks')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['WO_Project'])
                ->addColumn($columns['Service_Name'])
                ->addColumn($columns['Service_Type'])
                ->addColumn($columns['RateList(Year)'])
                ->addColumn($columns['Annual_Cost(excl-Dis)'])
                ->addColumn($columns['Annual_Cost(incl-Dis)'])
                ->addColumn($columns['vCPU'])
                ->addColumn($columns['RAM(GB)'])
                ->addColumn($columns['HDD(GB)'])
                ->addColumn($columns['VM_Mgmt_Cost'])
                ->addColumn($columns['Backup(GB)'])
                ->addColumn($columns['Backup(Nodes)'])
                ->addColumn($columns['Manpower'])
                ->addColumn($columns['Data(GB_monthly)'])
                ->addColumn($columns['Email_IDs'])
                ->addColumn($columns['Email_Space(GB)'])
                ->addColumn($columns['Rack_Space'])
                ->addColumn($columns['Rack_Power'])
                ->addColumn($columns['Bandwidth(Mbps)'])
                ->addColumn($columns['DB_license'])
                ->addColumn($columns['OT_Install_Cost'])
                ->addColumn($columns['Business_Support(%)'])
                ->addColumn($columns['Business_Support_Cost'])
                ->addColumn($columns['Remarks']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('WO_Project')
                ->setOptionsFor('Service_Name')
                ->setOptionsFor('Service_Type')
                ->setOptionsFor('RateList(Year)');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_WO_Project_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('WO_Project', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_WO_Project_search');
            
            $filterBuilder->addColumn(
                $columns['WO_Project'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('service_name_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_Service_Name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Service_Name', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_Service_Name_search');
            
            $text_editor = new TextEdit('Service_Name');
            
            $filterBuilder->addColumn(
                $columns['Service_Name'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('service_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_Service_Type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Service_Type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_Service_Type_search');
            
            $text_editor = new TextEdit('Service_Type');
            
            $filterBuilder->addColumn(
                $columns['Service_Type'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('ratelist(year)_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_RateList(Year)_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('RateList(Year)', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_details_RateList(Year)_search');
            
            $text_editor = new TextEdit('RateList(Year)');
            
            $filterBuilder->addColumn(
                $columns['RateList(Year)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('annual_cost(excl-dis)_edit');
            
            $filterBuilder->addColumn(
                $columns['Annual_Cost(excl-Dis)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('annual_cost(incl-dis)_edit');
            
            $filterBuilder->addColumn(
                $columns['Annual_Cost(incl-Dis)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('vcpu_edit');
            
            $filterBuilder->addColumn(
                $columns['vCPU'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('ram(gb)_edit');
            
            $filterBuilder->addColumn(
                $columns['RAM(GB)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('hdd(gb)_edit');
            
            $filterBuilder->addColumn(
                $columns['HDD(GB)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('vm_mgmt_cost_edit');
            
            $filterBuilder->addColumn(
                $columns['VM_Mgmt_Cost'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('backup(gb)_edit');
            
            $filterBuilder->addColumn(
                $columns['Backup(GB)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('backup(nodes)_edit');
            
            $filterBuilder->addColumn(
                $columns['Backup(Nodes)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('manpower_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['Manpower'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('data(gb_monthly)_edit');
            
            $filterBuilder->addColumn(
                $columns['Data(GB_monthly)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('email_ids_edit');
            
            $filterBuilder->addColumn(
                $columns['Email_IDs'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('email_space(gb)_edit');
            
            $filterBuilder->addColumn(
                $columns['Email_Space(GB)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('rack_space_edit');
            
            $filterBuilder->addColumn(
                $columns['Rack_Space'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('rack_power_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['Rack_Power'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('bandwidth(mbps)_edit');
            
            $filterBuilder->addColumn(
                $columns['Bandwidth(Mbps)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('db_license_edit');
            
            $filterBuilder->addColumn(
                $columns['DB_license'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('ot_install_cost_edit');
            
            $filterBuilder->addColumn(
                $columns['OT_Install_Cost'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('business_support(%)_edit');
            
            $filterBuilder->addColumn(
                $columns['Business_Support(%)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('business_support_cost_edit');
            
            $filterBuilder->addColumn(
                $columns['Business_Support_Cost'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Remarks');
            
            $filterBuilder->addColumn(
                $columns['Remarks'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Name', 'Service_Name_Name', 'Service Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Type', 'Service_Type_Name', 'Service Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('RateList(Year)', 'RateList(Year)_Name', 'Rate List(Year)', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Annual_Cost(excl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', 'Annual Cost(excl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Annual_Cost(incl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', 'Annual Cost(incl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for vCPU field
            //
            $column = new NumberViewColumn('vCPU', 'vCPU', 'VCPU', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for RAM(GB) field
            //
            $column = new NumberViewColumn('RAM(GB)', 'RAM(GB)', 'RAM(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for HDD(GB) field
            //
            $column = new NumberViewColumn('HDD(GB)', 'HDD(GB)', 'HDD(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for VM_Mgmt_Cost field
            //
            $column = new NumberViewColumn('VM_Mgmt_Cost', 'VM_Mgmt_Cost', 'VM Mgmt Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Backup(GB) field
            //
            $column = new NumberViewColumn('Backup(GB)', 'Backup(GB)', 'Backup(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Backup(Nodes) field
            //
            $column = new NumberViewColumn('Backup(Nodes)', 'Backup(Nodes)', 'Backup(Nodes)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Manpower field
            //
            $column = new TextViewColumn('Manpower', 'Manpower', 'Manpower', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Data(GB_monthly) field
            //
            $column = new NumberViewColumn('Data(GB_monthly)', 'Data(GB_monthly)', 'Data(GB Monthly)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Email_IDs field
            //
            $column = new NumberViewColumn('Email_IDs', 'Email_IDs', 'Email IDs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Email_Space(GB) field
            //
            $column = new NumberViewColumn('Email_Space(GB)', 'Email_Space(GB)', 'Email Space(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Rack_Space field
            //
            $column = new NumberViewColumn('Rack_Space', 'Rack_Space', 'Rack Space', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Rack_Power field
            //
            $column = new TextViewColumn('Rack_Power', 'Rack_Power', 'Rack Power', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Bandwidth(Mbps) field
            //
            $column = new NumberViewColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', 'Bandwidth(Mbps)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for DB_license field
            //
            $column = new NumberViewColumn('DB_license', 'DB_license', 'DB License', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OT_Install_Cost field
            //
            $column = new NumberViewColumn('OT_Install_Cost', 'OT_Install_Cost', 'OT Install Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Business_Support(%) field
            //
            $column = new NumberViewColumn('Business_Support(%)', 'Business_Support(%)', 'Business Support(%)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Business_Support_Cost field
            //
            $column = new NumberViewColumn('Business_Support_Cost', 'Business_Support_Cost', 'Business Support Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Name', 'Service_Name_Name', 'Service Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Type', 'Service_Type_Name', 'Service Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('RateList(Year)', 'RateList(Year)_Name', 'Rate List(Year)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Annual_Cost(excl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', 'Annual Cost(excl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Annual_Cost(incl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', 'Annual Cost(incl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for vCPU field
            //
            $column = new NumberViewColumn('vCPU', 'vCPU', 'VCPU', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for RAM(GB) field
            //
            $column = new NumberViewColumn('RAM(GB)', 'RAM(GB)', 'RAM(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for HDD(GB) field
            //
            $column = new NumberViewColumn('HDD(GB)', 'HDD(GB)', 'HDD(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for VM_Mgmt_Cost field
            //
            $column = new NumberViewColumn('VM_Mgmt_Cost', 'VM_Mgmt_Cost', 'VM Mgmt Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Backup(GB) field
            //
            $column = new NumberViewColumn('Backup(GB)', 'Backup(GB)', 'Backup(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Backup(Nodes) field
            //
            $column = new NumberViewColumn('Backup(Nodes)', 'Backup(Nodes)', 'Backup(Nodes)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Manpower field
            //
            $column = new TextViewColumn('Manpower', 'Manpower', 'Manpower', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Data(GB_monthly) field
            //
            $column = new NumberViewColumn('Data(GB_monthly)', 'Data(GB_monthly)', 'Data(GB Monthly)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Email_IDs field
            //
            $column = new NumberViewColumn('Email_IDs', 'Email_IDs', 'Email IDs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Email_Space(GB) field
            //
            $column = new NumberViewColumn('Email_Space(GB)', 'Email_Space(GB)', 'Email Space(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Rack_Space field
            //
            $column = new NumberViewColumn('Rack_Space', 'Rack_Space', 'Rack Space', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Rack_Power field
            //
            $column = new TextViewColumn('Rack_Power', 'Rack_Power', 'Rack Power', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Bandwidth(Mbps) field
            //
            $column = new NumberViewColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', 'Bandwidth(Mbps)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for DB_license field
            //
            $column = new NumberViewColumn('DB_license', 'DB_license', 'DB License', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for OT_Install_Cost field
            //
            $column = new NumberViewColumn('OT_Install_Cost', 'OT_Install_Cost', 'OT Install Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Business_Support(%) field
            //
            $column = new NumberViewColumn('Business_Support(%)', 'Business_Support(%)', 'Business Support(%)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Business_Support_Cost field
            //
            $column = new NumberViewColumn('Business_Support_Cost', 'Business_Support_Cost', 'Business Support Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for WO_Project field
            //
            $editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('WO Project', 'WO_Project', 'WO_Project_Project', 'edit_bd_work_order_bd_work_order_details_WO_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Service_Name field
            //
            $editor = new DynamicCombobox('service_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_service_name`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service Name', 'Service_Name', 'Service_Name_Name', 'edit_bd_work_order_bd_work_order_details_Service_Name_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Service_Type field
            //
            $editor = new DynamicCombobox('service_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service Type', 'Service_Type', 'Service_Type_Name', 'edit_bd_work_order_bd_work_order_details_Service_Type_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for RateList(Year) field
            //
            $editor = new DynamicCombobox('ratelist(year)_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Rate List(Year)', 'RateList(Year)', 'RateList(Year)_Name', 'edit_bd_work_order_bd_work_order_details_RateList(Year)_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Annual_Cost(excl-Dis) field
            //
            $editor = new TextEdit('annual_cost(excl-dis)_edit');
            $editColumn = new CustomEditColumn('Annual Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Annual_Cost(incl-Dis) field
            //
            $editor = new TextEdit('annual_cost(incl-dis)_edit');
            $editColumn = new CustomEditColumn('Annual Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for vCPU field
            //
            $editor = new TextEdit('vcpu_edit');
            $editColumn = new CustomEditColumn('VCPU', 'vCPU', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for RAM(GB) field
            //
            $editor = new TextEdit('ram(gb)_edit');
            $editColumn = new CustomEditColumn('RAM(GB)', 'RAM(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for HDD(GB) field
            //
            $editor = new TextEdit('hdd(gb)_edit');
            $editColumn = new CustomEditColumn('HDD(GB)', 'HDD(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for VM_Mgmt_Cost field
            //
            $editor = new TextEdit('vm_mgmt_cost_edit');
            $editColumn = new CustomEditColumn('VM Mgmt Cost', 'VM_Mgmt_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Backup(GB) field
            //
            $editor = new TextEdit('backup(gb)_edit');
            $editColumn = new CustomEditColumn('Backup(GB)', 'Backup(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Backup(Nodes) field
            //
            $editor = new TextEdit('backup(nodes)_edit');
            $editColumn = new CustomEditColumn('Backup(Nodes)', 'Backup(Nodes)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Manpower field
            //
            $editor = new TextEdit('manpower_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Manpower', 'Manpower', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Data(GB_monthly) field
            //
            $editor = new TextEdit('data(gb_monthly)_edit');
            $editColumn = new CustomEditColumn('Data(GB Monthly)', 'Data(GB_monthly)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Email_IDs field
            //
            $editor = new TextEdit('email_ids_edit');
            $editColumn = new CustomEditColumn('Email IDs', 'Email_IDs', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Email_Space(GB) field
            //
            $editor = new TextEdit('email_space(gb)_edit');
            $editColumn = new CustomEditColumn('Email Space(GB)', 'Email_Space(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Rack_Space field
            //
            $editor = new TextEdit('rack_space_edit');
            $editColumn = new CustomEditColumn('Rack Space', 'Rack_Space', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Rack_Power field
            //
            $editor = new TextEdit('rack_power_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Rack Power', 'Rack_Power', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Bandwidth(Mbps) field
            //
            $editor = new TextEdit('bandwidth(mbps)_edit');
            $editColumn = new CustomEditColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for DB_license field
            //
            $editor = new TextEdit('db_license_edit');
            $editColumn = new CustomEditColumn('DB License', 'DB_license', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for OT_Install_Cost field
            //
            $editor = new TextEdit('ot_install_cost_edit');
            $editColumn = new CustomEditColumn('OT Install Cost', 'OT_Install_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Business_Support(%) field
            //
            $editor = new TextEdit('business_support(%)_edit');
            $editColumn = new CustomEditColumn('Business Support(%)', 'Business_Support(%)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Business_Support_Cost field
            //
            $editor = new TextEdit('business_support_cost_edit');
            $editColumn = new CustomEditColumn('Business Support Cost', 'Business_Support_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for WO_Project field
            //
            $editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('WO Project', 'WO_Project', 'WO_Project_Project', 'multi_edit_bd_work_order_bd_work_order_details_WO_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Service_Name field
            //
            $editor = new DynamicCombobox('service_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_service_name`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service Name', 'Service_Name', 'Service_Name_Name', 'multi_edit_bd_work_order_bd_work_order_details_Service_Name_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Service_Type field
            //
            $editor = new DynamicCombobox('service_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service Type', 'Service_Type', 'Service_Type_Name', 'multi_edit_bd_work_order_bd_work_order_details_Service_Type_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for RateList(Year) field
            //
            $editor = new DynamicCombobox('ratelist(year)_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Rate List(Year)', 'RateList(Year)', 'RateList(Year)_Name', 'multi_edit_bd_work_order_bd_work_order_details_RateList(Year)_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Annual_Cost(excl-Dis) field
            //
            $editor = new TextEdit('annual_cost(excl-dis)_edit');
            $editColumn = new CustomEditColumn('Annual Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Annual_Cost(incl-Dis) field
            //
            $editor = new TextEdit('annual_cost(incl-dis)_edit');
            $editColumn = new CustomEditColumn('Annual Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for vCPU field
            //
            $editor = new TextEdit('vcpu_edit');
            $editColumn = new CustomEditColumn('VCPU', 'vCPU', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for RAM(GB) field
            //
            $editor = new TextEdit('ram(gb)_edit');
            $editColumn = new CustomEditColumn('RAM(GB)', 'RAM(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for HDD(GB) field
            //
            $editor = new TextEdit('hdd(gb)_edit');
            $editColumn = new CustomEditColumn('HDD(GB)', 'HDD(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for VM_Mgmt_Cost field
            //
            $editor = new TextEdit('vm_mgmt_cost_edit');
            $editColumn = new CustomEditColumn('VM Mgmt Cost', 'VM_Mgmt_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Backup(GB) field
            //
            $editor = new TextEdit('backup(gb)_edit');
            $editColumn = new CustomEditColumn('Backup(GB)', 'Backup(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Backup(Nodes) field
            //
            $editor = new TextEdit('backup(nodes)_edit');
            $editColumn = new CustomEditColumn('Backup(Nodes)', 'Backup(Nodes)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Manpower field
            //
            $editor = new TextEdit('manpower_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Manpower', 'Manpower', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Data(GB_monthly) field
            //
            $editor = new TextEdit('data(gb_monthly)_edit');
            $editColumn = new CustomEditColumn('Data(GB Monthly)', 'Data(GB_monthly)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Email_IDs field
            //
            $editor = new TextEdit('email_ids_edit');
            $editColumn = new CustomEditColumn('Email IDs', 'Email_IDs', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Email_Space(GB) field
            //
            $editor = new TextEdit('email_space(gb)_edit');
            $editColumn = new CustomEditColumn('Email Space(GB)', 'Email_Space(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Rack_Space field
            //
            $editor = new TextEdit('rack_space_edit');
            $editColumn = new CustomEditColumn('Rack Space', 'Rack_Space', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Rack_Power field
            //
            $editor = new TextEdit('rack_power_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Rack Power', 'Rack_Power', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Bandwidth(Mbps) field
            //
            $editor = new TextEdit('bandwidth(mbps)_edit');
            $editColumn = new CustomEditColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for DB_license field
            //
            $editor = new TextEdit('db_license_edit');
            $editColumn = new CustomEditColumn('DB License', 'DB_license', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for OT_Install_Cost field
            //
            $editor = new TextEdit('ot_install_cost_edit');
            $editColumn = new CustomEditColumn('OT Install Cost', 'OT_Install_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Business_Support(%) field
            //
            $editor = new TextEdit('business_support(%)_edit');
            $editColumn = new CustomEditColumn('Business Support(%)', 'Business_Support(%)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Business_Support_Cost field
            //
            $editor = new TextEdit('business_support_cost_edit');
            $editColumn = new CustomEditColumn('Business Support Cost', 'Business_Support_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for WO_Project field
            //
            $editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('WO Project', 'WO_Project', 'WO_Project_Project', 'insert_bd_work_order_bd_work_order_details_WO_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Service_Name field
            //
            $editor = new DynamicCombobox('service_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_service_name`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service Name', 'Service_Name', 'Service_Name_Name', 'insert_bd_work_order_bd_work_order_details_Service_Name_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Service_Type field
            //
            $editor = new DynamicCombobox('service_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service Type', 'Service_Type', 'Service_Type_Name', 'insert_bd_work_order_bd_work_order_details_Service_Type_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for RateList(Year) field
            //
            $editor = new DynamicCombobox('ratelist(year)_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Rate List(Year)', 'RateList(Year)', 'RateList(Year)_Name', 'insert_bd_work_order_bd_work_order_details_RateList(Year)_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Annual_Cost(excl-Dis) field
            //
            $editor = new TextEdit('annual_cost(excl-dis)_edit');
            $editColumn = new CustomEditColumn('Annual Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Annual_Cost(incl-Dis) field
            //
            $editor = new TextEdit('annual_cost(incl-dis)_edit');
            $editColumn = new CustomEditColumn('Annual Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for vCPU field
            //
            $editor = new TextEdit('vcpu_edit');
            $editColumn = new CustomEditColumn('VCPU', 'vCPU', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for RAM(GB) field
            //
            $editor = new TextEdit('ram(gb)_edit');
            $editColumn = new CustomEditColumn('RAM(GB)', 'RAM(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for HDD(GB) field
            //
            $editor = new TextEdit('hdd(gb)_edit');
            $editColumn = new CustomEditColumn('HDD(GB)', 'HDD(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for VM_Mgmt_Cost field
            //
            $editor = new TextEdit('vm_mgmt_cost_edit');
            $editColumn = new CustomEditColumn('VM Mgmt Cost', 'VM_Mgmt_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Backup(GB) field
            //
            $editor = new TextEdit('backup(gb)_edit');
            $editColumn = new CustomEditColumn('Backup(GB)', 'Backup(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Backup(Nodes) field
            //
            $editor = new TextEdit('backup(nodes)_edit');
            $editColumn = new CustomEditColumn('Backup(Nodes)', 'Backup(Nodes)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Manpower field
            //
            $editor = new TextEdit('manpower_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Manpower', 'Manpower', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Data(GB_monthly) field
            //
            $editor = new TextEdit('data(gb_monthly)_edit');
            $editColumn = new CustomEditColumn('Data(GB Monthly)', 'Data(GB_monthly)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Email_IDs field
            //
            $editor = new TextEdit('email_ids_edit');
            $editColumn = new CustomEditColumn('Email IDs', 'Email_IDs', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Email_Space(GB) field
            //
            $editor = new TextEdit('email_space(gb)_edit');
            $editColumn = new CustomEditColumn('Email Space(GB)', 'Email_Space(GB)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Rack_Space field
            //
            $editor = new TextEdit('rack_space_edit');
            $editColumn = new CustomEditColumn('Rack Space', 'Rack_Space', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Rack_Power field
            //
            $editor = new TextEdit('rack_power_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Rack Power', 'Rack_Power', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Bandwidth(Mbps) field
            //
            $editor = new TextEdit('bandwidth(mbps)_edit');
            $editColumn = new CustomEditColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for DB_license field
            //
            $editor = new TextEdit('db_license_edit');
            $editColumn = new CustomEditColumn('DB License', 'DB_license', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for OT_Install_Cost field
            //
            $editor = new TextEdit('ot_install_cost_edit');
            $editColumn = new CustomEditColumn('OT Install Cost', 'OT_Install_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Business_Support(%) field
            //
            $editor = new TextEdit('business_support(%)_edit');
            $editColumn = new CustomEditColumn('Business Support(%)', 'Business_Support(%)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Business_Support_Cost field
            //
            $editor = new TextEdit('business_support_cost_edit');
            $editColumn = new CustomEditColumn('Business Support Cost', 'Business_Support_Cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Name', 'Service_Name_Name', 'Service Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Type', 'Service_Type_Name', 'Service Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('RateList(Year)', 'RateList(Year)_Name', 'Rate List(Year)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Annual_Cost(excl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', 'Annual Cost(excl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Annual_Cost(incl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', 'Annual Cost(incl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for vCPU field
            //
            $column = new NumberViewColumn('vCPU', 'vCPU', 'VCPU', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for RAM(GB) field
            //
            $column = new NumberViewColumn('RAM(GB)', 'RAM(GB)', 'RAM(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for HDD(GB) field
            //
            $column = new NumberViewColumn('HDD(GB)', 'HDD(GB)', 'HDD(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for VM_Mgmt_Cost field
            //
            $column = new NumberViewColumn('VM_Mgmt_Cost', 'VM_Mgmt_Cost', 'VM Mgmt Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Backup(GB) field
            //
            $column = new NumberViewColumn('Backup(GB)', 'Backup(GB)', 'Backup(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Backup(Nodes) field
            //
            $column = new NumberViewColumn('Backup(Nodes)', 'Backup(Nodes)', 'Backup(Nodes)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Manpower field
            //
            $column = new TextViewColumn('Manpower', 'Manpower', 'Manpower', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Data(GB_monthly) field
            //
            $column = new NumberViewColumn('Data(GB_monthly)', 'Data(GB_monthly)', 'Data(GB Monthly)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Email_IDs field
            //
            $column = new NumberViewColumn('Email_IDs', 'Email_IDs', 'Email IDs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Email_Space(GB) field
            //
            $column = new NumberViewColumn('Email_Space(GB)', 'Email_Space(GB)', 'Email Space(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Rack_Space field
            //
            $column = new NumberViewColumn('Rack_Space', 'Rack_Space', 'Rack Space', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Rack_Power field
            //
            $column = new TextViewColumn('Rack_Power', 'Rack_Power', 'Rack Power', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Bandwidth(Mbps) field
            //
            $column = new NumberViewColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', 'Bandwidth(Mbps)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for DB_license field
            //
            $column = new NumberViewColumn('DB_license', 'DB_license', 'DB License', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for OT_Install_Cost field
            //
            $column = new NumberViewColumn('OT_Install_Cost', 'OT_Install_Cost', 'OT Install Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Business_Support(%) field
            //
            $column = new NumberViewColumn('Business_Support(%)', 'Business_Support(%)', 'Business Support(%)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Business_Support_Cost field
            //
            $column = new NumberViewColumn('Business_Support_Cost', 'Business_Support_Cost', 'Business Support Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Name', 'Service_Name_Name', 'Service Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Type', 'Service_Type_Name', 'Service Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('RateList(Year)', 'RateList(Year)_Name', 'Rate List(Year)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Annual_Cost(excl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', 'Annual Cost(excl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Annual_Cost(incl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', 'Annual Cost(incl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for vCPU field
            //
            $column = new NumberViewColumn('vCPU', 'vCPU', 'VCPU', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for RAM(GB) field
            //
            $column = new NumberViewColumn('RAM(GB)', 'RAM(GB)', 'RAM(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for HDD(GB) field
            //
            $column = new NumberViewColumn('HDD(GB)', 'HDD(GB)', 'HDD(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for VM_Mgmt_Cost field
            //
            $column = new NumberViewColumn('VM_Mgmt_Cost', 'VM_Mgmt_Cost', 'VM Mgmt Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Backup(GB) field
            //
            $column = new NumberViewColumn('Backup(GB)', 'Backup(GB)', 'Backup(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Backup(Nodes) field
            //
            $column = new NumberViewColumn('Backup(Nodes)', 'Backup(Nodes)', 'Backup(Nodes)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Manpower field
            //
            $column = new TextViewColumn('Manpower', 'Manpower', 'Manpower', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Data(GB_monthly) field
            //
            $column = new NumberViewColumn('Data(GB_monthly)', 'Data(GB_monthly)', 'Data(GB Monthly)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Email_IDs field
            //
            $column = new NumberViewColumn('Email_IDs', 'Email_IDs', 'Email IDs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Email_Space(GB) field
            //
            $column = new NumberViewColumn('Email_Space(GB)', 'Email_Space(GB)', 'Email Space(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Rack_Space field
            //
            $column = new NumberViewColumn('Rack_Space', 'Rack_Space', 'Rack Space', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Rack_Power field
            //
            $column = new TextViewColumn('Rack_Power', 'Rack_Power', 'Rack Power', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Bandwidth(Mbps) field
            //
            $column = new NumberViewColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', 'Bandwidth(Mbps)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for DB_license field
            //
            $column = new NumberViewColumn('DB_license', 'DB_license', 'DB License', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for OT_Install_Cost field
            //
            $column = new NumberViewColumn('OT_Install_Cost', 'OT_Install_Cost', 'OT Install Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Business_Support(%) field
            //
            $column = new NumberViewColumn('Business_Support(%)', 'Business_Support(%)', 'Business Support(%)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Business_Support_Cost field
            //
            $column = new NumberViewColumn('Business_Support_Cost', 'Business_Support_Cost', 'Business Support Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Name', 'Service_Name_Name', 'Service Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Service_Type', 'Service_Type_Name', 'Service Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('RateList(Year)', 'RateList(Year)_Name', 'Rate List(Year)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Annual_Cost(excl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(excl-Dis)', 'Annual_Cost(excl-Dis)', 'Annual Cost(excl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Annual_Cost(incl-Dis) field
            //
            $column = new NumberViewColumn('Annual_Cost(incl-Dis)', 'Annual_Cost(incl-Dis)', 'Annual Cost(incl-Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for vCPU field
            //
            $column = new NumberViewColumn('vCPU', 'vCPU', 'VCPU', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for RAM(GB) field
            //
            $column = new NumberViewColumn('RAM(GB)', 'RAM(GB)', 'RAM(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for HDD(GB) field
            //
            $column = new NumberViewColumn('HDD(GB)', 'HDD(GB)', 'HDD(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for VM_Mgmt_Cost field
            //
            $column = new NumberViewColumn('VM_Mgmt_Cost', 'VM_Mgmt_Cost', 'VM Mgmt Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Backup(GB) field
            //
            $column = new NumberViewColumn('Backup(GB)', 'Backup(GB)', 'Backup(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Backup(Nodes) field
            //
            $column = new NumberViewColumn('Backup(Nodes)', 'Backup(Nodes)', 'Backup(Nodes)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Manpower field
            //
            $column = new TextViewColumn('Manpower', 'Manpower', 'Manpower', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Data(GB_monthly) field
            //
            $column = new NumberViewColumn('Data(GB_monthly)', 'Data(GB_monthly)', 'Data(GB Monthly)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Email_IDs field
            //
            $column = new NumberViewColumn('Email_IDs', 'Email_IDs', 'Email IDs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Email_Space(GB) field
            //
            $column = new NumberViewColumn('Email_Space(GB)', 'Email_Space(GB)', 'Email Space(GB)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Rack_Space field
            //
            $column = new NumberViewColumn('Rack_Space', 'Rack_Space', 'Rack Space', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Rack_Power field
            //
            $column = new TextViewColumn('Rack_Power', 'Rack_Power', 'Rack Power', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Bandwidth(Mbps) field
            //
            $column = new NumberViewColumn('Bandwidth(Mbps)', 'Bandwidth(Mbps)', 'Bandwidth(Mbps)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for DB_license field
            //
            $column = new NumberViewColumn('DB_license', 'DB_license', 'DB License', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for OT_Install_Cost field
            //
            $column = new NumberViewColumn('OT_Install_Cost', 'OT_Install_Cost', 'OT Install Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Business_Support(%) field
            //
            $column = new NumberViewColumn('Business_Support(%)', 'Business_Support(%)', 'Business Support(%)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Business_Support_Cost field
            //
            $column = new NumberViewColumn('Business_Support_Cost', 'Business_Support_Cost', 'Business Support Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_bd_work_order_bd_work_order_details_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_service_name`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_bd_work_order_bd_work_order_details_Service_Name_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_bd_work_order_bd_work_order_details_Service_Type_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_bd_work_order_bd_work_order_details_RateList(Year)_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_bd_work_order_bd_work_order_details_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_service_name`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_bd_work_order_bd_work_order_details_Service_Name_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_bd_work_order_bd_work_order_details_Service_Type_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_bd_work_order_bd_work_order_details_RateList(Year)_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_bd_work_order_bd_work_order_details_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_service_name`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_bd_work_order_bd_work_order_details_Service_Name_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_bd_work_order_bd_work_order_details_Service_Type_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_bd_work_order_bd_work_order_details_RateList(Year)_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_bd_work_order_bd_work_order_details_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_service_name`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_bd_work_order_bd_work_order_details_Service_Name_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_bd_work_order_bd_work_order_details_Service_Type_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_others`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name'),
                    new StringField('Type', true),
                    new IntegerField('Type_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_bd_work_order_bd_work_order_details_RateList(Year)_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class bd_work_order_bd_work_order_docPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Bd Work Order Doc');
            $this->SetMenuLabel('Bd Work Order Doc');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order_doc`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('WO_Project', true),
                    new StringField('Proposal_Doc'),
                    new StringField('Work_Order_Doc'),
                    new StringField('Remarks')
                )
            );
            $this->dataset->AddLookupField('WO_Project', 'bd_work_order', new IntegerField('id'), new IntegerField('Project', false, false, false, false, 'WO_Project_Project', 'WO_Project_Project_bd_work_order'), 'WO_Project_Project_bd_work_order');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'WO_Project', 'WO_Project_Project', 'WO Project'),
                new FilterColumn($this->dataset, 'Proposal_Doc', 'Proposal_Doc', 'Proposal Doc'),
                new FilterColumn($this->dataset, 'Work_Order_Doc', 'Work_Order_Doc', 'Work Order Doc'),
                new FilterColumn($this->dataset, 'Remarks', 'Remarks', 'Remarks')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['WO_Project'])
                ->addColumn($columns['Proposal_Doc'])
                ->addColumn($columns['Work_Order_Doc'])
                ->addColumn($columns['Remarks']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('WO_Project');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_doc_WO_Project_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('WO_Project', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_bd_work_order_bd_work_order_doc_WO_Project_search');
            
            $filterBuilder->addColumn(
                $columns['WO_Project'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('proposal_doc_edit');
            $main_editor->SetMaxLength(80);
            
            $filterBuilder->addColumn(
                $columns['Proposal_Doc'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('work_order_doc_edit');
            $main_editor->SetMaxLength(80);
            
            $filterBuilder->addColumn(
                $columns['Work_Order_Doc'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Remarks');
            
            $filterBuilder->addColumn(
                $columns['Remarks'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Proposal_Doc field
            //
            $column = new TextViewColumn('Proposal_Doc', 'Proposal_Doc', 'Proposal Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Work_Order_Doc field
            //
            $column = new TextViewColumn('Work_Order_Doc', 'Work_Order_Doc', 'Work Order Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Proposal_Doc field
            //
            $column = new TextViewColumn('Proposal_Doc', 'Proposal_Doc', 'Proposal Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Work_Order_Doc field
            //
            $column = new TextViewColumn('Work_Order_Doc', 'Work_Order_Doc', 'Work Order Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for WO_Project field
            //
            $editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('WO Project', 'WO_Project', 'WO_Project_Project', 'edit_bd_work_order_bd_work_order_doc_WO_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Proposal_Doc field
            //
            $editor = new TextEdit('proposal_doc_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Proposal Doc', 'Proposal_Doc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Work_Order_Doc field
            //
            $editor = new TextEdit('work_order_doc_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Work Order Doc', 'Work_Order_Doc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for WO_Project field
            //
            $editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('WO Project', 'WO_Project', 'WO_Project_Project', 'multi_edit_bd_work_order_bd_work_order_doc_WO_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Proposal_Doc field
            //
            $editor = new TextEdit('proposal_doc_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Proposal Doc', 'Proposal_Doc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Work_Order_Doc field
            //
            $editor = new TextEdit('work_order_doc_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Work Order Doc', 'Work_Order_Doc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for WO_Project field
            //
            $editor = new DynamicCombobox('wo_project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('WO Project', 'WO_Project', 'WO_Project_Project', 'insert_bd_work_order_bd_work_order_doc_WO_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Proposal_Doc field
            //
            $editor = new TextEdit('proposal_doc_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Proposal Doc', 'Proposal_Doc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Work_Order_Doc field
            //
            $editor = new TextEdit('work_order_doc_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Work Order Doc', 'Work_Order_Doc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Proposal_Doc field
            //
            $column = new TextViewColumn('Proposal_Doc', 'Proposal_Doc', 'Proposal Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Work_Order_Doc field
            //
            $column = new TextViewColumn('Work_Order_Doc', 'Work_Order_Doc', 'Work Order Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Proposal_Doc field
            //
            $column = new TextViewColumn('Proposal_Doc', 'Proposal_Doc', 'Proposal Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Work_Order_Doc field
            //
            $column = new TextViewColumn('Work_Order_Doc', 'Work_Order_Doc', 'Work Order Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Project field
            //
            $column = new NumberViewColumn('WO_Project', 'WO_Project_Project', 'WO Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Proposal_Doc field
            //
            $column = new TextViewColumn('Proposal_Doc', 'Proposal_Doc', 'Proposal Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Work_Order_Doc field
            //
            $column = new TextViewColumn('Work_Order_Doc', 'Work_Order_Doc', 'Work Order Doc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_bd_work_order_bd_work_order_doc_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_bd_work_order_bd_work_order_doc_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_bd_work_order_bd_work_order_doc_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_bd_work_order_bd_work_order_doc_WO_Project_search', 'id', 'Project', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class bd_work_orderPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Work Order');
            $this->SetMenuLabel('Work Order');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bd_work_order`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Project', true),
                    new DateField('Contract_Start_Date'),
                    new DateField('Contract_End_Date'),
                    new IntegerField('Costing_Ratelist'),
                    new IntegerField('Total_Amount(excl-Tax_Dis)'),
                    new IntegerField('Total_Amount(excl-Tax)'),
                    new IntegerField('Total_Value(current_year)'),
                    new StringField('Remarks')
                )
            );
            $this->dataset->AddLookupField('Project', 'vw_project_type', new IntegerField('id'), new StringField('Project', false, false, false, false, 'Project_Project', 'Project_Project_vw_project_type'), 'Project_Project_vw_project_type');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'Project', 'Project_Project', 'Project'),
                new FilterColumn($this->dataset, 'Contract_Start_Date', 'Contract_Start_Date', 'Contract Start Date'),
                new FilterColumn($this->dataset, 'Contract_End_Date', 'Contract_End_Date', 'Contract End Date'),
                new FilterColumn($this->dataset, 'Costing_Ratelist', 'Costing_Ratelist', 'Costing Ratelist'),
                new FilterColumn($this->dataset, 'Total_Amount(excl-Tax_Dis)', 'Total_Amount(excl-Tax_Dis)', 'Total Amount(excl-Tax Dis)'),
                new FilterColumn($this->dataset, 'Total_Amount(excl-Tax)', 'Total_Amount(excl-Tax)', 'Total Amount(excl-Tax)'),
                new FilterColumn($this->dataset, 'Total_Value(current_year)', 'Total_Value(current_year)', 'Total Value(current Year)'),
                new FilterColumn($this->dataset, 'Remarks', 'Remarks', 'Remarks')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['Project'])
                ->addColumn($columns['Contract_Start_Date'])
                ->addColumn($columns['Contract_End_Date'])
                ->addColumn($columns['Costing_Ratelist'])
                ->addColumn($columns['Total_Amount(excl-Tax_Dis)'])
                ->addColumn($columns['Total_Amount(excl-Tax)'])
                ->addColumn($columns['Total_Value(current_year)'])
                ->addColumn($columns['Remarks']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id')
                ->setOptionsFor('Project')
                ->setOptionsFor('Contract_Start_Date')
                ->setOptionsFor('Contract_End_Date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('project_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_bd_work_order_Project_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Project', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_bd_work_order_Project_search');
            
            $filterBuilder->addColumn(
                $columns['Project'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('contract_start_date_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Contract_Start_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('contract_end_date_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Contract_End_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('costing_ratelist_edit');
            
            $filterBuilder->addColumn(
                $columns['Costing_Ratelist'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('total_amount(excl-tax_dis)_edit');
            
            $filterBuilder->addColumn(
                $columns['Total_Amount(excl-Tax_Dis)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('total_amount(excl-tax)_edit');
            
            $filterBuilder->addColumn(
                $columns['Total_Amount(excl-Tax)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('total_value(current_year)_edit');
            
            $filterBuilder->addColumn(
                $columns['Total_Value(current_year)'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Remarks');
            
            $filterBuilder->addColumn(
                $columns['Remarks'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionsForPage('bd_work_order.bd_work_order_details')->HasViewGrant() && $withDetails)
            {
            //
            // View column for bd_work_order_bd_work_order_details detail
            //
            $column = new DetailColumn(array('id'), 'bd_work_order.bd_work_order_details', 'bd_work_order_bd_work_order_details_handler', $this->dataset, 'Bd Work Order Details');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('bd_work_order.bd_work_order_doc')->HasViewGrant() && $withDetails)
            {
            //
            // View column for bd_work_order_bd_work_order_doc detail
            //
            $column = new DetailColumn(array('id'), 'bd_work_order.bd_work_order_doc', 'bd_work_order_bd_work_order_doc_handler', $this->dataset, 'Bd Work Order Doc');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Project field
            //
            $column = new TextViewColumn('Project', 'Project_Project', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Contract_Start_Date field
            //
            $column = new DateTimeViewColumn('Contract_Start_Date', 'Contract_Start_Date', 'Contract Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Contract_End_Date field
            //
            $column = new DateTimeViewColumn('Contract_End_Date', 'Contract_End_Date', 'Contract End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Costing_Ratelist field
            //
            $column = new NumberViewColumn('Costing_Ratelist', 'Costing_Ratelist', 'Costing Ratelist', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax_Dis) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax_Dis)', 'Total_Amount(excl-Tax_Dis)', 'Total Amount(excl-Tax Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax)', 'Total_Amount(excl-Tax)', 'Total Amount(excl-Tax)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Total_Value(current_year) field
            //
            $column = new NumberViewColumn('Total_Value(current_year)', 'Total_Value(current_year)', 'Total Value(current Year)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Project field
            //
            $column = new TextViewColumn('Project', 'Project_Project', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Contract_Start_Date field
            //
            $column = new DateTimeViewColumn('Contract_Start_Date', 'Contract_Start_Date', 'Contract Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Contract_End_Date field
            //
            $column = new DateTimeViewColumn('Contract_End_Date', 'Contract_End_Date', 'Contract End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Costing_Ratelist field
            //
            $column = new NumberViewColumn('Costing_Ratelist', 'Costing_Ratelist', 'Costing Ratelist', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax_Dis) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax_Dis)', 'Total_Amount(excl-Tax_Dis)', 'Total Amount(excl-Tax Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax)', 'Total_Amount(excl-Tax)', 'Total Amount(excl-Tax)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Total_Value(current_year) field
            //
            $column = new NumberViewColumn('Total_Value(current_year)', 'Total_Value(current_year)', 'Total Value(current Year)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Project field
            //
            $editor = new DynamicCombobox('project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_project_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Project')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project', 'Project', 'Project_Project', 'edit_bd_work_order_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Contract_Start_Date field
            //
            $editor = new DateTimeEdit('contract_start_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Contract Start Date', 'Contract_Start_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Contract_End_Date field
            //
            $editor = new DateTimeEdit('contract_end_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Contract End Date', 'Contract_End_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Costing_Ratelist field
            //
            $editor = new TextEdit('costing_ratelist_edit');
            $editColumn = new CustomEditColumn('Costing Ratelist', 'Costing_Ratelist', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Total_Amount(excl-Tax_Dis) field
            //
            $editor = new TextEdit('total_amount(excl-tax_dis)_edit');
            $editColumn = new CustomEditColumn('Total Amount(excl-Tax Dis)', 'Total_Amount(excl-Tax_Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Total_Amount(excl-Tax) field
            //
            $editor = new TextEdit('total_amount(excl-tax)_edit');
            $editColumn = new CustomEditColumn('Total Amount(excl-Tax)', 'Total_Amount(excl-Tax)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Total_Value(current_year) field
            //
            $editor = new TextEdit('total_value(current_year)_edit');
            $editColumn = new CustomEditColumn('Total Value(current Year)', 'Total_Value(current_year)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Project field
            //
            $editor = new DynamicCombobox('project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_project_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Project')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project', 'Project', 'Project_Project', 'multi_edit_bd_work_order_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Contract_Start_Date field
            //
            $editor = new DateTimeEdit('contract_start_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Contract Start Date', 'Contract_Start_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Contract_End_Date field
            //
            $editor = new DateTimeEdit('contract_end_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Contract End Date', 'Contract_End_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Costing_Ratelist field
            //
            $editor = new TextEdit('costing_ratelist_edit');
            $editColumn = new CustomEditColumn('Costing Ratelist', 'Costing_Ratelist', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Total_Amount(excl-Tax_Dis) field
            //
            $editor = new TextEdit('total_amount(excl-tax_dis)_edit');
            $editColumn = new CustomEditColumn('Total Amount(excl-Tax Dis)', 'Total_Amount(excl-Tax_Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Total_Amount(excl-Tax) field
            //
            $editor = new TextEdit('total_amount(excl-tax)_edit');
            $editColumn = new CustomEditColumn('Total Amount(excl-Tax)', 'Total_Amount(excl-Tax)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Total_Value(current_year) field
            //
            $editor = new TextEdit('total_value(current_year)_edit');
            $editColumn = new CustomEditColumn('Total Value(current Year)', 'Total_Value(current_year)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Project field
            //
            $editor = new DynamicCombobox('project_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_project_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Project')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project', 'Project', 'Project_Project', 'insert_bd_work_order_Project_search', $editor, $this->dataset, $lookupDataset, 'id', 'Project', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Contract_Start_Date field
            //
            $editor = new DateTimeEdit('contract_start_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Contract Start Date', 'Contract_Start_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Contract_End_Date field
            //
            $editor = new DateTimeEdit('contract_end_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Contract End Date', 'Contract_End_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Costing_Ratelist field
            //
            $editor = new TextEdit('costing_ratelist_edit');
            $editColumn = new CustomEditColumn('Costing Ratelist', 'Costing_Ratelist', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Total_Amount(excl-Tax_Dis) field
            //
            $editor = new TextEdit('total_amount(excl-tax_dis)_edit');
            $editColumn = new CustomEditColumn('Total Amount(excl-Tax Dis)', 'Total_Amount(excl-Tax_Dis)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Total_Amount(excl-Tax) field
            //
            $editor = new TextEdit('total_amount(excl-tax)_edit');
            $editColumn = new CustomEditColumn('Total Amount(excl-Tax)', 'Total_Amount(excl-Tax)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Total_Value(current_year) field
            //
            $editor = new TextEdit('total_value(current_year)_edit');
            $editColumn = new CustomEditColumn('Total Value(current Year)', 'Total_Value(current_year)', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextAreaEdit('remarks_edit', 50, 8);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Project field
            //
            $column = new TextViewColumn('Project', 'Project_Project', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Contract_Start_Date field
            //
            $column = new DateTimeViewColumn('Contract_Start_Date', 'Contract_Start_Date', 'Contract Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Contract_End_Date field
            //
            $column = new DateTimeViewColumn('Contract_End_Date', 'Contract_End_Date', 'Contract End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Costing_Ratelist field
            //
            $column = new NumberViewColumn('Costing_Ratelist', 'Costing_Ratelist', 'Costing Ratelist', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax_Dis) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax_Dis)', 'Total_Amount(excl-Tax_Dis)', 'Total Amount(excl-Tax Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax)', 'Total_Amount(excl-Tax)', 'Total Amount(excl-Tax)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Total_Value(current_year) field
            //
            $column = new NumberViewColumn('Total_Value(current_year)', 'Total_Value(current_year)', 'Total Value(current Year)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Project field
            //
            $column = new TextViewColumn('Project', 'Project_Project', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Contract_Start_Date field
            //
            $column = new DateTimeViewColumn('Contract_Start_Date', 'Contract_Start_Date', 'Contract Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Contract_End_Date field
            //
            $column = new DateTimeViewColumn('Contract_End_Date', 'Contract_End_Date', 'Contract End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Costing_Ratelist field
            //
            $column = new NumberViewColumn('Costing_Ratelist', 'Costing_Ratelist', 'Costing Ratelist', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax_Dis) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax_Dis)', 'Total_Amount(excl-Tax_Dis)', 'Total Amount(excl-Tax Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax)', 'Total_Amount(excl-Tax)', 'Total Amount(excl-Tax)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Total_Value(current_year) field
            //
            $column = new NumberViewColumn('Total_Value(current_year)', 'Total_Value(current_year)', 'Total Value(current Year)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Project field
            //
            $column = new TextViewColumn('Project', 'Project_Project', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Contract_Start_Date field
            //
            $column = new DateTimeViewColumn('Contract_Start_Date', 'Contract_Start_Date', 'Contract Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Contract_End_Date field
            //
            $column = new DateTimeViewColumn('Contract_End_Date', 'Contract_End_Date', 'Contract End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Costing_Ratelist field
            //
            $column = new NumberViewColumn('Costing_Ratelist', 'Costing_Ratelist', 'Costing Ratelist', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax_Dis) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax_Dis)', 'Total_Amount(excl-Tax_Dis)', 'Total Amount(excl-Tax Dis)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Total_Amount(excl-Tax) field
            //
            $column = new NumberViewColumn('Total_Amount(excl-Tax)', 'Total_Amount(excl-Tax)', 'Total Amount(excl-Tax)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Total_Value(current_year) field
            //
            $column = new NumberViewColumn('Total_Value(current_year)', 'Total_Value(current_year)', 'Total Value(current Year)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new bd_work_order_bd_work_order_detailsPage('bd_work_order_bd_work_order_details', $this, array('WO_Project'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('bd_work_order.bd_work_order_details'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('bd_work_order.bd_work_order_details'));
            $detailPage->SetHttpHandlerName('bd_work_order_bd_work_order_details_handler');
            $handler = new PageHTTPHandler('bd_work_order_bd_work_order_details_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new bd_work_order_bd_work_order_docPage('bd_work_order_bd_work_order_doc', $this, array('WO_Project'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('bd_work_order.bd_work_order_doc'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('bd_work_order.bd_work_order_doc'));
            $detailPage->SetHttpHandlerName('bd_work_order_bd_work_order_doc_handler');
            $handler = new PageHTTPHandler('bd_work_order_bd_work_order_doc_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_project_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Project')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_bd_work_order_Project_search', 'id', 'Project', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_project_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Project')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_bd_work_order_Project_search', 'id', 'Project', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_project_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Project')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_bd_work_order_Project_search', 'id', 'Project', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_project_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Project')
                )
            );
            $lookupDataset->setOrderByField('Project', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_bd_work_order_Project_search', 'id', 'Project', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new bd_work_orderPage("bd_work_order", "bd_work_order.php", GetCurrentUserPermissionsForPage("bd_work_order"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("bd_work_order"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
