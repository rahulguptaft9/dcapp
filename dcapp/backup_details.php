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
    
    
    
    class backup_detailsPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Backup Details');
            $this->SetMenuLabel('Backup Details');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`backup_details`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('Host', true),
                    new StringField('Path', true),
                    new DateField('Initiation_Date', true),
                    new StringField('Initiation_Details'),
                    new IntegerField('Backup_Location1', true),
                    new IntegerField('Backup_Location2'),
                    new IntegerField('Backup_Location3'),
                    new StringField('Initiated_By'),
                    new IntegerField('Deactivation_Flag', true),
                    new IntegerField('Duplicate_Of'),
                    new StringField('Remarks')
                )
            );
            $this->dataset->AddLookupField('Host', 'vw_ip_infra', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Host_Name', 'Host_Name_vw_ip_infra'), 'Host_Name_vw_ip_infra');
            $this->dataset->AddLookupField('Backup_Location1', 'vw_ip_infra', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Backup_Location1_Name', 'Backup_Location1_Name_vw_ip_infra'), 'Backup_Location1_Name_vw_ip_infra');
            $this->dataset->AddLookupField('Backup_Location2', 'vw_ip_infra', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Backup_Location2_Name', 'Backup_Location2_Name_vw_ip_infra'), 'Backup_Location2_Name_vw_ip_infra');
            $this->dataset->AddLookupField('Backup_Location3', 'vw_ip_infra', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Backup_Location3_Name', 'Backup_Location3_Name_vw_ip_infra'), 'Backup_Location3_Name_vw_ip_infra');
            $this->dataset->AddLookupField('Duplicate_Of', 'vw_ip_infra', new IntegerField('id'), new StringField('Name', false, false, false, false, 'Duplicate_Of_Name', 'Duplicate_Of_Name_vw_ip_infra'), 'Duplicate_Of_Name_vw_ip_infra');
            $this->dataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'backup_details.deactivation_flag = 0'));
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(50);
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
                new FilterColumn($this->dataset, 'Host', 'Host_Name', 'Host'),
                new FilterColumn($this->dataset, 'Path', 'Path', 'Path'),
                new FilterColumn($this->dataset, 'Initiation_Date', 'Initiation_Date', 'Initiation Date'),
                new FilterColumn($this->dataset, 'Initiation_Details', 'Initiation_Details', 'Initiation Details'),
                new FilterColumn($this->dataset, 'Backup_Location1', 'Backup_Location1_Name', 'Backup Location1'),
                new FilterColumn($this->dataset, 'Backup_Location2', 'Backup_Location2_Name', 'Backup Location2'),
                new FilterColumn($this->dataset, 'Backup_Location3', 'Backup_Location3_Name', 'Backup Location3'),
                new FilterColumn($this->dataset, 'Initiated_By', 'Initiated_By', 'Initiated By'),
                new FilterColumn($this->dataset, 'Duplicate_Of', 'Duplicate_Of_Name', 'Duplicate Of'),
                new FilterColumn($this->dataset, 'Remarks', 'Remarks', 'Remarks'),
                new FilterColumn($this->dataset, 'Deactivation_Flag', 'Deactivation_Flag', 'Deactivation Flag')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['Host'])
                ->addColumn($columns['Path'])
                ->addColumn($columns['Initiation_Date'])
                ->addColumn($columns['Initiation_Details'])
                ->addColumn($columns['Backup_Location1'])
                ->addColumn($columns['Backup_Location2'])
                ->addColumn($columns['Backup_Location3'])
                ->addColumn($columns['Initiated_By'])
                ->addColumn($columns['Duplicate_Of'])
                ->addColumn($columns['Remarks']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Host')
                ->setOptionsFor('Initiation_Date')
                ->setOptionsFor('Backup_Location1')
                ->setOptionsFor('Backup_Location2')
                ->setOptionsFor('Backup_Location3')
                ->setOptionsFor('Duplicate_Of');
            
            $columnFilter
                ->setNumberOfValuesToDisplayFor('Host', 100)
                ->setNumberOfValuesToDisplayFor('Backup_Location1', 100)
                ->setNumberOfValuesToDisplayFor('Backup_Location2', 100)
                ->setNumberOfValuesToDisplayFor('Backup_Location3', 100)
                ->setNumberOfValuesToDisplayFor('Duplicate_Of', 5000);
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
            
            $main_editor = new DynamicCombobox('host_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_backup_details_Host_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Host', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_backup_details_Host_search');
            
            $filterBuilder->addColumn(
                $columns['Host'],
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
            
            $main_editor = new TextEdit('path_edit');
            
            $filterBuilder->addColumn(
                $columns['Path'],
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
            
            $main_editor = new DateTimeEdit('initiation_date_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Initiation_Date'],
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
            
            $main_editor = new TextEdit('initiation_details_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Initiation_Details'],
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
            
            $main_editor = new DynamicCombobox('backup_location1_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_backup_details_Backup_Location1_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Backup_Location1', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_backup_details_Backup_Location1_search');
            
            $filterBuilder->addColumn(
                $columns['Backup_Location1'],
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
            
            $main_editor = new DynamicCombobox('backup_location2_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_backup_details_Backup_Location2_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Backup_Location2', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_backup_details_Backup_Location2_search');
            
            $filterBuilder->addColumn(
                $columns['Backup_Location2'],
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
            
            $main_editor = new DynamicCombobox('backup_location3_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_backup_details_Backup_Location3_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Backup_Location3', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_backup_details_Backup_Location3_search');
            
            $filterBuilder->addColumn(
                $columns['Backup_Location3'],
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
            
            $main_editor = new TextEdit('initiated_by_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['Initiated_By'],
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
            
            $main_editor = new DynamicCombobox('duplicate_of_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_backup_details_Duplicate_Of_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Duplicate_Of', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_backup_details_Duplicate_Of_search');
            
            $filterBuilder->addColumn(
                $columns['Duplicate_Of'],
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
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
            $column = new TextViewColumn('Host', 'Host_Name', 'Host', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Path field
            //
            $column = new TextViewColumn('Path', 'Path', 'Path', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Initiation_Date field
            //
            $column = new DateTimeViewColumn('Initiation_Date', 'Initiation_Date', 'Initiation Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Initiation_Details field
            //
            $column = new TextViewColumn('Initiation_Details', 'Initiation_Details', 'Initiation Details', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location1', 'Backup_Location1_Name', 'Backup Location1', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location2', 'Backup_Location2_Name', 'Backup Location2', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location3', 'Backup_Location3_Name', 'Backup Location3', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Initiated_By field
            //
            $column = new TextViewColumn('Initiated_By', 'Initiated_By', 'Initiated By', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Duplicate_Of', 'Duplicate_Of_Name', 'Duplicate Of', $this->dataset);
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
            $column = new TextViewColumn('Host', 'Host_Name', 'Host', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Path field
            //
            $column = new TextViewColumn('Path', 'Path', 'Path', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Initiation_Date field
            //
            $column = new DateTimeViewColumn('Initiation_Date', 'Initiation_Date', 'Initiation Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Initiation_Details field
            //
            $column = new TextViewColumn('Initiation_Details', 'Initiation_Details', 'Initiation Details', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location1', 'Backup_Location1_Name', 'Backup Location1', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location2', 'Backup_Location2_Name', 'Backup Location2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location3', 'Backup_Location3_Name', 'Backup Location3', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Initiated_By field
            //
            $column = new TextViewColumn('Initiated_By', 'Initiated_By', 'Initiated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Duplicate_Of', 'Duplicate_Of_Name', 'Duplicate Of', $this->dataset);
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
            // Edit column for Host field
            //
            $editor = new DynamicCombobox('host_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Host', 'Host', 'Host_Name', 'edit_backup_details_Host_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Path field
            //
            $editor = new TextEdit('path_edit');
            $editColumn = new CustomEditColumn('Path', 'Path', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Initiation_Date field
            //
            $editor = new DateTimeEdit('initiation_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Initiation Date', 'Initiation_Date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Initiation_Details field
            //
            $editor = new TextEdit('initiation_details_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Initiation Details', 'Initiation_Details', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Backup_Location1 field
            //
            $editor = new DynamicCombobox('backup_location1_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location1', 'Backup_Location1', 'Backup_Location1_Name', 'edit_backup_details_Backup_Location1_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Backup_Location2 field
            //
            $editor = new DynamicCombobox('backup_location2_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location2', 'Backup_Location2', 'Backup_Location2_Name', 'edit_backup_details_Backup_Location2_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Backup_Location3 field
            //
            $editor = new DynamicCombobox('backup_location3_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location3', 'Backup_Location3', 'Backup_Location3_Name', 'edit_backup_details_Backup_Location3_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Initiated_By field
            //
            $editor = new TextEdit('initiated_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Initiated By', 'Initiated_By', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Duplicate_Of field
            //
            $editor = new DynamicCombobox('duplicate_of_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Duplicate Of', 'Duplicate_Of', 'Duplicate_Of_Name', 'edit_backup_details_Duplicate_Of_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
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
            // Edit column for Host field
            //
            $editor = new DynamicCombobox('host_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Host', 'Host', 'Host_Name', 'multi_edit_backup_details_Host_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Path field
            //
            $editor = new TextEdit('path_edit');
            $editColumn = new CustomEditColumn('Path', 'Path', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Initiation_Date field
            //
            $editor = new DateTimeEdit('initiation_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Initiation Date', 'Initiation_Date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Initiation_Details field
            //
            $editor = new TextEdit('initiation_details_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Initiation Details', 'Initiation_Details', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Backup_Location1 field
            //
            $editor = new DynamicCombobox('backup_location1_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location1', 'Backup_Location1', 'Backup_Location1_Name', 'multi_edit_backup_details_Backup_Location1_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Backup_Location2 field
            //
            $editor = new DynamicCombobox('backup_location2_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location2', 'Backup_Location2', 'Backup_Location2_Name', 'multi_edit_backup_details_Backup_Location2_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Backup_Location3 field
            //
            $editor = new DynamicCombobox('backup_location3_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location3', 'Backup_Location3', 'Backup_Location3_Name', 'multi_edit_backup_details_Backup_Location3_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Initiated_By field
            //
            $editor = new TextEdit('initiated_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Initiated By', 'Initiated_By', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Duplicate_Of field
            //
            $editor = new DynamicCombobox('duplicate_of_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Duplicate Of', 'Duplicate_Of', 'Duplicate_Of_Name', 'multi_edit_backup_details_Duplicate_Of_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
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
            // Edit column for Host field
            //
            $editor = new DynamicCombobox('host_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Host', 'Host', 'Host_Name', 'insert_backup_details_Host_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Path field
            //
            $editor = new TextEdit('path_edit');
            $editColumn = new CustomEditColumn('Path', 'Path', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Initiation_Date field
            //
            $editor = new DateTimeEdit('initiation_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Initiation Date', 'Initiation_Date', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Initiation_Details field
            //
            $editor = new TextEdit('initiation_details_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Initiation Details', 'Initiation_Details', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Backup_Location1 field
            //
            $editor = new DynamicCombobox('backup_location1_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location1', 'Backup_Location1', 'Backup_Location1_Name', 'insert_backup_details_Backup_Location1_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Backup_Location2 field
            //
            $editor = new DynamicCombobox('backup_location2_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location2', 'Backup_Location2', 'Backup_Location2_Name', 'insert_backup_details_Backup_Location2_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Backup_Location3 field
            //
            $editor = new DynamicCombobox('backup_location3_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $editColumn = new DynamicLookupEditColumn('Backup Location3', 'Backup_Location3', 'Backup_Location3_Name', 'insert_backup_details_Backup_Location3_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Initiated_By field
            //
            $editor = new TextEdit('initiated_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Initiated By', 'Initiated_By', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Duplicate_Of field
            //
            $editor = new DynamicCombobox('duplicate_of_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Duplicate Of', 'Duplicate_Of', 'Duplicate_Of_Name', 'insert_backup_details_Duplicate_Of_search', $editor, $this->dataset, $lookupDataset, 'id', 'Name', '');
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
            // View column for Name field
            //
            $column = new TextViewColumn('Host', 'Host_Name', 'Host', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Path field
            //
            $column = new TextViewColumn('Path', 'Path', 'Path', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Initiation_Date field
            //
            $column = new DateTimeViewColumn('Initiation_Date', 'Initiation_Date', 'Initiation Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Initiation_Details field
            //
            $column = new TextViewColumn('Initiation_Details', 'Initiation_Details', 'Initiation Details', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location1', 'Backup_Location1_Name', 'Backup Location1', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location2', 'Backup_Location2_Name', 'Backup Location2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location3', 'Backup_Location3_Name', 'Backup Location3', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Initiated_By field
            //
            $column = new TextViewColumn('Initiated_By', 'Initiated_By', 'Initiated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Duplicate_Of', 'Duplicate_Of_Name', 'Duplicate Of', $this->dataset);
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
            $column = new TextViewColumn('Host', 'Host_Name', 'Host', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Path field
            //
            $column = new TextViewColumn('Path', 'Path', 'Path', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Initiation_Date field
            //
            $column = new DateTimeViewColumn('Initiation_Date', 'Initiation_Date', 'Initiation Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Initiation_Details field
            //
            $column = new TextViewColumn('Initiation_Details', 'Initiation_Details', 'Initiation Details', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location1', 'Backup_Location1_Name', 'Backup Location1', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location2', 'Backup_Location2_Name', 'Backup Location2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location3', 'Backup_Location3_Name', 'Backup Location3', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Initiated_By field
            //
            $column = new TextViewColumn('Initiated_By', 'Initiated_By', 'Initiated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Duplicate_Of', 'Duplicate_Of_Name', 'Duplicate Of', $this->dataset);
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
            $column = new TextViewColumn('Host', 'Host_Name', 'Host', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Path field
            //
            $column = new TextViewColumn('Path', 'Path', 'Path', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Initiation_Date field
            //
            $column = new DateTimeViewColumn('Initiation_Date', 'Initiation_Date', 'Initiation Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Initiation_Details field
            //
            $column = new TextViewColumn('Initiation_Details', 'Initiation_Details', 'Initiation Details', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location1', 'Backup_Location1_Name', 'Backup Location1', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location2', 'Backup_Location2_Name', 'Backup Location2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Backup_Location3', 'Backup_Location3_Name', 'Backup Location3', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Initiated_By field
            //
            $column = new TextViewColumn('Initiated_By', 'Initiated_By', 'Initiated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Duplicate_Of', 'Duplicate_Of_Name', 'Duplicate Of', $this->dataset);
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
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
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
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_backup_details_Host_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_backup_details_Backup_Location1_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_backup_details_Backup_Location2_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_backup_details_Backup_Location3_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_backup_details_Duplicate_Of_search', 'id', 'Name', null, 500);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_backup_details_Host_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_backup_details_Backup_Location1_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_backup_details_Backup_Location2_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_backup_details_Backup_Location3_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_backup_details_Duplicate_Of_search', 'id', 'Name', null, 500);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_backup_details_Duplicate_Of_search', 'id', 'Name', null, 500);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_backup_details_Host_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_backup_details_Backup_Location1_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_backup_details_Backup_Location2_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_backup_details_Backup_Location3_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_backup_details_Duplicate_Of_search', 'id', 'Name', null, 500);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_backup_details_Host_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_backup_details_Backup_Location1_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_backup_details_Backup_Location2_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Type=20 or Type=21'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_backup_details_Backup_Location3_search', 'id', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`vw_ip_infra`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('Name'),
                    new IntegerField('Type'),
                    new IntegerField('Used_For')
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_backup_details_Duplicate_Of_search', 'id', 'Name', null, 500);
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
            $rowData['Initiated_By'] = $this->GetCurrentUserName();
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
        $Page = new backup_detailsPage("backup_details", "backup_details.php", GetCurrentUserPermissionsForPage("backup_details"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("backup_details"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
