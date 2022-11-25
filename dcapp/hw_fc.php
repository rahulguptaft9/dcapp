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
    
    
    
    class hw_fcPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle(' - Hw Fc');
            $this->SetMenuLabel(' - Hw Fc');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`hw_fc`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('CDAC_ID'),
                    new IntegerField('FC_Type', true),
                    new IntegerField('FC_Qty', true),
                    new StringField('Remarks')
                )
            );
            $this->dataset->AddLookupField('CDAC_ID', 'hw_details', new IntegerField('id'), new StringField('CDAC_ID', false, false, false, false, 'CDAC_ID_CDAC_ID', 'CDAC_ID_CDAC_ID_hw_details'), 'CDAC_ID_CDAC_ID_hw_details');
            $this->dataset->AddLookupField('FC_Type', 'vw_hw_network', new IntegerField('id'), new StringField('NW_Card', false, false, false, false, 'FC_Type_NW_Card', 'FC_Type_NW_Card_vw_hw_network'), 'FC_Type_NW_Card_vw_hw_network');
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
                new FilterColumn($this->dataset, 'CDAC_ID', 'CDAC_ID_CDAC_ID', 'CDAC ID'),
                new FilterColumn($this->dataset, 'FC_Type', 'FC_Type_NW_Card', 'FC Type'),
                new FilterColumn($this->dataset, 'FC_Qty', 'FC_Qty', 'FC Qty'),
                new FilterColumn($this->dataset, 'Remarks', 'Remarks', 'Remarks')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['CDAC_ID'])
                ->addColumn($columns['FC_Type'])
                ->addColumn($columns['FC_Qty'])
                ->addColumn($columns['Remarks']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('CDAC_ID')
                ->setOptionsFor('FC_Type');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('cdac_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_hw_fc_CDAC_ID_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('CDAC_ID', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_hw_fc_CDAC_ID_search');
            
            $text_editor = new TextEdit('CDAC_ID');
            
            $filterBuilder->addColumn(
                $columns['CDAC_ID'],
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
            
            $main_editor = new DynamicCombobox('fc_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_hw_fc_FC_Type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('FC_Type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_hw_fc_FC_Type_search');
            
            $text_editor = new TextEdit('FC_Type');
            
            $filterBuilder->addColumn(
                $columns['FC_Type'],
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
            
            $main_editor = new TextEdit('fc_qty_edit');
            
            $filterBuilder->addColumn(
                $columns['FC_Qty'],
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
            // View column for CDAC_ID field
            //
            $column = new TextViewColumn('CDAC_ID', 'CDAC_ID_CDAC_ID', 'CDAC ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for NW_Card field
            //
            $column = new TextViewColumn('FC_Type', 'FC_Type_NW_Card', 'FC Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FC_Qty field
            //
            $column = new TextViewColumn('FC_Qty', 'FC_Qty', 'FC Qty', $this->dataset);
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
            $column->SetMaxLength(150);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for CDAC_ID field
            //
            $column = new TextViewColumn('CDAC_ID', 'CDAC_ID_CDAC_ID', 'CDAC ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for NW_Card field
            //
            $column = new TextViewColumn('FC_Type', 'FC_Type_NW_Card', 'FC Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FC_Qty field
            //
            $column = new TextViewColumn('FC_Qty', 'FC_Qty', 'FC Qty', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(150);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for CDAC_ID field
            //
            $editor = new DynamicCombobox('cdac_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`hw_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('CDAC_ID', true, true),
                    new IntegerField('Asset_Owner', true),
                    new IntegerField('Purchased_Under'),
                    new IntegerField('PO_Number'),
                    new IntegerField('Item_Type', true),
                    new StringField('Serial_No'),
                    new StringField('Service_Tag'),
                    new IntegerField('Make_Model', true),
                    new IntegerField('Processor'),
                    new IntegerField('Processor_Qty'),
                    new IntegerField('RAM_GB'),
                    new IntegerField('HardDisk_GB'),
                    new IntegerField('RAID_Controller'),
                    new StringField('NVRAM_MB'),
                    new StringField('Flash_MB'),
                    new IntegerField('Enclouser_Qty'),
                    new IntegerField('Power_Supply'),
                    new IntegerField('Rack_No'),
                    new IntegerField('Status', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CDAC_ID not like "%/RC/%"'));
            $editColumn = new DynamicLookupEditColumn('CDAC ID', 'CDAC_ID', 'CDAC_ID_CDAC_ID', 'edit_hw_fc_CDAC_ID_search', $editor, $this->dataset, $lookupDataset, 'id', 'CDAC_ID', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for FC_Type field
            //
            $editor = new ComboBox('fc_type_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_hw_network`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('NW_Card', true),
                    new IntegerField('Total_Speed')
                )
            );
            $lookupDataset->setOrderByField('NW_Card', 'ASC');
            $editColumn = new LookUpEditColumn(
                'FC Type', 
                'FC_Type', 
                $editor, 
                $this->dataset, 'id', 'NW_Card', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for FC_Qty field
            //
            $editor = new TextEdit('fc_qty_edit');
            $editColumn = new CustomEditColumn('FC Qty', 'FC_Qty', $editor, $this->dataset);
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
            // Edit column for CDAC_ID field
            //
            $editor = new DynamicCombobox('cdac_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`hw_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('CDAC_ID', true, true),
                    new IntegerField('Asset_Owner', true),
                    new IntegerField('Purchased_Under'),
                    new IntegerField('PO_Number'),
                    new IntegerField('Item_Type', true),
                    new StringField('Serial_No'),
                    new StringField('Service_Tag'),
                    new IntegerField('Make_Model', true),
                    new IntegerField('Processor'),
                    new IntegerField('Processor_Qty'),
                    new IntegerField('RAM_GB'),
                    new IntegerField('HardDisk_GB'),
                    new IntegerField('RAID_Controller'),
                    new StringField('NVRAM_MB'),
                    new StringField('Flash_MB'),
                    new IntegerField('Enclouser_Qty'),
                    new IntegerField('Power_Supply'),
                    new IntegerField('Rack_No'),
                    new IntegerField('Status', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CDAC_ID not like "%/RC/%"'));
            $editColumn = new DynamicLookupEditColumn('CDAC ID', 'CDAC_ID', 'CDAC_ID_CDAC_ID', 'multi_edit_hw_fc_CDAC_ID_search', $editor, $this->dataset, $lookupDataset, 'id', 'CDAC_ID', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for FC_Type field
            //
            $editor = new ComboBox('fc_type_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_hw_network`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('NW_Card', true),
                    new IntegerField('Total_Speed')
                )
            );
            $lookupDataset->setOrderByField('NW_Card', 'ASC');
            $editColumn = new LookUpEditColumn(
                'FC Type', 
                'FC_Type', 
                $editor, 
                $this->dataset, 'id', 'NW_Card', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for FC_Qty field
            //
            $editor = new TextEdit('fc_qty_edit');
            $editColumn = new CustomEditColumn('FC Qty', 'FC_Qty', $editor, $this->dataset);
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
            // Edit column for CDAC_ID field
            //
            $editor = new DynamicCombobox('cdac_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`hw_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('CDAC_ID', true, true),
                    new IntegerField('Asset_Owner', true),
                    new IntegerField('Purchased_Under'),
                    new IntegerField('PO_Number'),
                    new IntegerField('Item_Type', true),
                    new StringField('Serial_No'),
                    new StringField('Service_Tag'),
                    new IntegerField('Make_Model', true),
                    new IntegerField('Processor'),
                    new IntegerField('Processor_Qty'),
                    new IntegerField('RAM_GB'),
                    new IntegerField('HardDisk_GB'),
                    new IntegerField('RAID_Controller'),
                    new StringField('NVRAM_MB'),
                    new StringField('Flash_MB'),
                    new IntegerField('Enclouser_Qty'),
                    new IntegerField('Power_Supply'),
                    new IntegerField('Rack_No'),
                    new IntegerField('Status', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CDAC_ID not like "%/RC/%"'));
            $editColumn = new DynamicLookupEditColumn('CDAC ID', 'CDAC_ID', 'CDAC_ID_CDAC_ID', 'insert_hw_fc_CDAC_ID_search', $editor, $this->dataset, $lookupDataset, 'id', 'CDAC_ID', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for FC_Type field
            //
            $editor = new ComboBox('fc_type_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_hw_network`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('NW_Card', true),
                    new IntegerField('Total_Speed')
                )
            );
            $lookupDataset->setOrderByField('NW_Card', 'ASC');
            $editColumn = new LookUpEditColumn(
                'FC Type', 
                'FC_Type', 
                $editor, 
                $this->dataset, 'id', 'NW_Card', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for FC_Qty field
            //
            $editor = new TextEdit('fc_qty_edit');
            $editColumn = new CustomEditColumn('FC Qty', 'FC_Qty', $editor, $this->dataset);
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
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CDAC_ID field
            //
            $column = new TextViewColumn('CDAC_ID', 'CDAC_ID_CDAC_ID', 'CDAC ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for NW_Card field
            //
            $column = new TextViewColumn('FC_Type', 'FC_Type_NW_Card', 'FC Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for FC_Qty field
            //
            $column = new TextViewColumn('FC_Qty', 'FC_Qty', 'FC Qty', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(150);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for CDAC_ID field
            //
            $column = new TextViewColumn('CDAC_ID', 'CDAC_ID_CDAC_ID', 'CDAC ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for NW_Card field
            //
            $column = new TextViewColumn('FC_Type', 'FC_Type_NW_Card', 'FC Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for FC_Qty field
            //
            $column = new TextViewColumn('FC_Qty', 'FC_Qty', 'FC Qty', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(150);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for CDAC_ID field
            //
            $column = new TextViewColumn('CDAC_ID', 'CDAC_ID_CDAC_ID', 'CDAC ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for NW_Card field
            //
            $column = new TextViewColumn('FC_Type', 'FC_Type_NW_Card', 'FC Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for FC_Qty field
            //
            $column = new TextViewColumn('FC_Qty', 'FC_Qty', 'FC Qty', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remarks field
            //
            $column = new TextViewColumn('Remarks', 'Remarks', 'Remarks', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(150);
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
                '`hw_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('CDAC_ID', true, true),
                    new IntegerField('Asset_Owner', true),
                    new IntegerField('Purchased_Under'),
                    new IntegerField('PO_Number'),
                    new IntegerField('Item_Type', true),
                    new StringField('Serial_No'),
                    new StringField('Service_Tag'),
                    new IntegerField('Make_Model', true),
                    new IntegerField('Processor'),
                    new IntegerField('Processor_Qty'),
                    new IntegerField('RAM_GB'),
                    new IntegerField('HardDisk_GB'),
                    new IntegerField('RAID_Controller'),
                    new StringField('NVRAM_MB'),
                    new StringField('Flash_MB'),
                    new IntegerField('Enclouser_Qty'),
                    new IntegerField('Power_Supply'),
                    new IntegerField('Rack_No'),
                    new IntegerField('Status', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CDAC_ID not like "%/RC/%"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_hw_fc_CDAC_ID_search', 'id', 'CDAC_ID', null, 2000);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`hw_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('CDAC_ID', true, true),
                    new IntegerField('Asset_Owner', true),
                    new IntegerField('Purchased_Under'),
                    new IntegerField('PO_Number'),
                    new IntegerField('Item_Type', true),
                    new StringField('Serial_No'),
                    new StringField('Service_Tag'),
                    new IntegerField('Make_Model', true),
                    new IntegerField('Processor'),
                    new IntegerField('Processor_Qty'),
                    new IntegerField('RAM_GB'),
                    new IntegerField('HardDisk_GB'),
                    new IntegerField('RAID_Controller'),
                    new StringField('NVRAM_MB'),
                    new StringField('Flash_MB'),
                    new IntegerField('Enclouser_Qty'),
                    new IntegerField('Power_Supply'),
                    new IntegerField('Rack_No'),
                    new IntegerField('Status', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CDAC_ID not like "%/RC/%"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_hw_fc_CDAC_ID_search', 'id', 'CDAC_ID', null, 2000);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_hw_network`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('NW_Card', true),
                    new IntegerField('Total_Speed')
                )
            );
            $lookupDataset->setOrderByField('NW_Card', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_hw_fc_FC_Type_search', 'id', 'NW_Card', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`hw_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('CDAC_ID', true, true),
                    new IntegerField('Asset_Owner', true),
                    new IntegerField('Purchased_Under'),
                    new IntegerField('PO_Number'),
                    new IntegerField('Item_Type', true),
                    new StringField('Serial_No'),
                    new StringField('Service_Tag'),
                    new IntegerField('Make_Model', true),
                    new IntegerField('Processor'),
                    new IntegerField('Processor_Qty'),
                    new IntegerField('RAM_GB'),
                    new IntegerField('HardDisk_GB'),
                    new IntegerField('RAID_Controller'),
                    new StringField('NVRAM_MB'),
                    new StringField('Flash_MB'),
                    new IntegerField('Enclouser_Qty'),
                    new IntegerField('Power_Supply'),
                    new IntegerField('Rack_No'),
                    new IntegerField('Status', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CDAC_ID not like "%/RC/%"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_hw_fc_CDAC_ID_search', 'id', 'CDAC_ID', null, 2000);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`hw_details`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('CDAC_ID', true, true),
                    new IntegerField('Asset_Owner', true),
                    new IntegerField('Purchased_Under'),
                    new IntegerField('PO_Number'),
                    new IntegerField('Item_Type', true),
                    new StringField('Serial_No'),
                    new StringField('Service_Tag'),
                    new IntegerField('Make_Model', true),
                    new IntegerField('Processor'),
                    new IntegerField('Processor_Qty'),
                    new IntegerField('RAM_GB'),
                    new IntegerField('HardDisk_GB'),
                    new IntegerField('RAID_Controller'),
                    new StringField('NVRAM_MB'),
                    new StringField('Flash_MB'),
                    new IntegerField('Enclouser_Qty'),
                    new IntegerField('Power_Supply'),
                    new IntegerField('Rack_No'),
                    new IntegerField('Status', true),
                    new StringField('Remarks')
                )
            );
            $lookupDataset->setOrderByField('CDAC_ID', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CDAC_ID not like "%/RC/%"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_hw_fc_CDAC_ID_search', 'id', 'CDAC_ID', null, 2000);
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
        $Page = new hw_fcPage("hw_fc", "hw_fc.php", GetCurrentUserPermissionsForPage("hw_fc"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("hw_fc"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
