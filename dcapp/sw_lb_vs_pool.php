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

    
    
    class sw_lb_vs_pool_VirtualServerNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_virtualserver`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $this->dataset->AddLookupField('VIP', 'vw_url_ip', new IntegerField('id'), new StringField('IP', false, false, false, false, 'VIP_IP', 'VIP_IP_vw_url_ip'), 'VIP_IP_vw_url_ip');
            $this->dataset->AddLookupField('Protocol', 'mst_others', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Protocol_Name', 'Protocol_Name_mst_others'), 'Protocol_Name_mst_others');
            $this->dataset->AddLookupField('Port', 'mst_nw_ports', new IntegerField('id'), new StringField('Port', false, false, false, false, 'Port_Port', 'Port_Port_mst_nw_ports'), 'Port_Port_mst_nw_ports');
            $this->dataset->AddLookupField('Persistence', 'mst_others', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Persistence_Name', 'Persistence_Name_mst_others'), 'Persistence_Name_mst_others');
            $this->dataset->AddLookupField('Algorithm', 'mst_others', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Algorithm_Name', 'Algorithm_Name_mst_others'), 'Algorithm_Name_mst_others');
            $this->dataset->AddLookupField('EdgeName', 'vw_infra_details', new IntegerField('id'), new StringField('CDAC_ID', false, false, false, false, 'EdgeName_CDAC_ID', 'EdgeName_CDAC_ID_vw_infra_details'), 'EdgeName_CDAC_ID_vw_infra_details');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Name', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for EdgeName field
            //
            $editor = new DynamicCombobox('edgename_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_infra_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('CDAC_ID', true),
                    new StringField('Type')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type like \'%Load Balancer%\''));
            $editColumn = new DynamicLookupEditColumn('Edge Name', 'EdgeName', 'EdgeName_CDAC_ID', 'insert_sw_lb_vs_pool_VirtualServerNestedPage_EdgeName_search', $editor, $this->dataset, $lookupDataset, 'id', 'CDAC_ID', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for VIP field
            //
            $editor = new DynamicCombobox('vip_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_url_ip`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('IPv4'),
                    new StringField('IP'),
                    new StringField('URL', true),
                    new StringField('NAT_IP'),
                    new IntegerField('Enable', true)
                )
            );
            $lookupDataset->setOrderByField('IP', 'ASC');
            $editColumn = new DynamicLookupEditColumn('VIP', 'VIP', 'VIP_IP', 'insert_sw_lb_vs_pool_VirtualServerNestedPage_VIP_search', $editor, $this->dataset, $lookupDataset, 'id', 'IP', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Protocol field
            //
            $editor = new DynamicCombobox('protocol_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type_ID=12'));
            $editColumn = new DynamicLookupEditColumn('Protocol', 'Protocol', 'Protocol_Name', 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Protocol_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetInsertDefaultValue('112');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Port field
            //
            $editor = new DynamicCombobox('port_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_nw_ports`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Port', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Port', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Port', 'Port', 'Port_Port', 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Port_search', $editor, $this->dataset, $lookupDataset, 'id', 'Port', '');
            $editColumn->SetInsertDefaultValue('5');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Persistence field
            //
            $editor = new DynamicCombobox('persistence_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type_ID=14'));
            $editColumn = new DynamicLookupEditColumn('Persistence', 'Persistence', 'Persistence_Name', 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Persistence_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetInsertDefaultValue('105');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Algorithm field
            //
            $editor = new DynamicCombobox('algorithm_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type_ID=15'));
            $editColumn = new DynamicLookupEditColumn('Algorithm', 'Algorithm', 'Algorithm_Name', 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Algorithm_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetInsertDefaultValue('108');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Remarks field
            //
            $editor = new TextEdit('remarks_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Remarks', 'Remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
       static public function getNestedInsertHandlerName()
        {
            return get_class() . '_form_insert';
        }
    
        public function GetGridInsertHandler()
        {
            return self::getNestedInsertHandlerName();
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class sw_lb_vs_poolPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Virtual Server Pool Mapping');
            $this->SetMenuLabel('Virtual Server Pool Mapping');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_vs_pool`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('VirtualServer', true),
                    new IntegerField('Pool', true),
                    new StringField('Remarks')
                )
            );
            $this->dataset->AddLookupField('VirtualServer', 'sw_lb_virtualserver', new IntegerField('id'), new StringField('Name', false, false, false, false, 'VirtualServer_Name', 'VirtualServer_Name_sw_lb_virtualserver'), 'VirtualServer_Name_sw_lb_virtualserver');
            $this->dataset->AddLookupField('Pool', 'mst_sw_lb_pool', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Pool_Name', 'Pool_Name_mst_sw_lb_pool'), 'Pool_Name_mst_sw_lb_pool');
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
                new FilterColumn($this->dataset, 'VirtualServer', 'VirtualServer_Name', 'Virtual Server'),
                new FilterColumn($this->dataset, 'Pool', 'Pool_Name', 'Pool'),
                new FilterColumn($this->dataset, 'Remarks', 'Remarks', 'Remarks')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['VirtualServer'])
                ->addColumn($columns['Pool'])
                ->addColumn($columns['Remarks']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('VirtualServer')
                ->setOptionsFor('Pool');
            
            $columnFilter
                ->setNumberOfValuesToDisplayFor('VirtualServer', 200)
                ->setNumberOfValuesToDisplayFor('Pool', 200);
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
            
            $main_editor = new DynamicCombobox('virtualserver_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_sw_lb_vs_pool_VirtualServer_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('VirtualServer', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_sw_lb_vs_pool_VirtualServer_search');
            
            $text_editor = new TextEdit('VirtualServer');
            
            $filterBuilder->addColumn(
                $columns['VirtualServer'],
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
            
            $main_editor = new DynamicCombobox('pool_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_sw_lb_vs_pool_Pool_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Pool', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_sw_lb_vs_pool_Pool_search');
            
            $filterBuilder->addColumn(
                $columns['Pool'],
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
            // View column for Name field
            //
            $column = new TextViewColumn('VirtualServer', 'VirtualServer_Name', 'Virtual Server', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Pool', 'Pool_Name', 'Pool', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Name field
            //
            $column = new TextViewColumn('VirtualServer', 'VirtualServer_Name', 'Virtual Server', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Pool', 'Pool_Name', 'Pool', $this->dataset);
            $column->SetOrderable(true);
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
            // Edit column for VirtualServer field
            //
            $editor = new DynamicCombobox('virtualserver_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_virtualserver`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Virtual Server', 'VirtualServer', 'VirtualServer_Name', 'edit_sw_lb_vs_pool_VirtualServer_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(sw_lb_vs_pool_VirtualServerNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Pool field
            //
            $editor = new DynamicCombobox('pool_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Pool', 'Pool', 'Pool_Name', '_sw_lb_vs_pool_Pool_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            // Edit column for VirtualServer field
            //
            $editor = new DynamicCombobox('virtualserver_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_virtualserver`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Virtual Server', 'VirtualServer', 'VirtualServer_Name', 'multi_edit_sw_lb_vs_pool_VirtualServer_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(sw_lb_vs_pool_VirtualServerNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Pool field
            //
            $editor = new DynamicCombobox('pool_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Pool', 'Pool', 'Pool_Name', 'multi_edit_sw_lb_vs_pool_Pool_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            // Edit column for VirtualServer field
            //
            $editor = new DynamicCombobox('virtualserver_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_virtualserver`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Virtual Server', 'VirtualServer', 'VirtualServer_Name', 'insert_sw_lb_vs_pool_VirtualServer_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(sw_lb_vs_pool_VirtualServerNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Pool field
            //
            $editor = new DynamicCombobox('pool_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Pool', 'Pool', 'Pool_Name', 'insert_sw_lb_vs_pool_Pool_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            // View column for Name field
            //
            $column = new TextViewColumn('VirtualServer', 'VirtualServer_Name', 'Virtual Server', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Pool', 'Pool_Name', 'Pool', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Name field
            //
            $column = new TextViewColumn('VirtualServer', 'VirtualServer_Name', 'Virtual Server', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Pool', 'Pool_Name', 'Pool', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Name field
            //
            $column = new TextViewColumn('VirtualServer', 'VirtualServer_Name', 'Virtual Server', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Pool', 'Pool_Name', 'Pool', $this->dataset);
            $column->SetOrderable(true);
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
                '`sw_lb_virtualserver`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_VirtualServer_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_Pool_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_virtualserver`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_sw_lb_vs_pool_VirtualServer_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_sw_lb_vs_pool_Pool_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_sw_lb_vs_pool_Pool_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_virtualserver`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_sw_lb_vs_pool_VirtualServer_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, '_sw_lb_vs_pool_Pool_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sw_lb_virtualserver`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true),
                    new IntegerField('EdgeName', true),
                    new IntegerField('VIP', true),
                    new IntegerField('Protocol', true),
                    new IntegerField('Port', true),
                    new IntegerField('Persistence', true),
                    new IntegerField('Algorithm', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_sw_lb_vs_pool_VirtualServer_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_sw_lb_pool`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Name', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_sw_lb_vs_pool_Pool_search', 'id', 'Name', null, 200);
            GetApplication()->RegisterHTTPHandler($handler);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_infra_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('CDAC_ID', true),
                    new StringField('Type')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type like \'%Load Balancer%\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_VirtualServerNestedPage_EdgeName_search', 'id', 'CDAC_ID', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_url_ip`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('IPv4'),
                    new StringField('IP'),
                    new StringField('URL', true),
                    new StringField('NAT_IP'),
                    new IntegerField('Enable', true)
                )
            );
            $lookupDataset->setOrderByField('IP', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_VirtualServerNestedPage_VIP_search', 'id', 'IP', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type_ID=12'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Protocol_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`mst_nw_ports`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('Port', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('Port', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Port_search', 'id', 'Port', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type_ID=14'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Persistence_search', 'id', 'Name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type_ID=15'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_sw_lb_vs_pool_VirtualServerNestedPage_Algorithm_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            new sw_lb_vs_pool_VirtualServerNestedPage($this, GetCurrentUserPermissionsForPage('sw_lb_vs_pool.VirtualServer'));
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
        $Page = new sw_lb_vs_poolPage("sw_lb_vs_pool", "sw_lb_vs_pool.php", GetCurrentUserPermissionsForPage("sw_lb_vs_pool"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("sw_lb_vs_pool"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
