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
    
    
    
    class DashboardPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Dashboard');
            $this->SetMenuLabel('Dashboard');
    
            $selectQuery = 'select  \'Physical Servers\' as Type, count(*) as Total from hw_details hw 
            where hw.CDAC_ID like \'CDACN/SVR/%\' AND Status = 1 
            group by Type
            UNION
            select  \'Virtual Servers\' as Type, count(*) as Total from hw_details hw 
            where hw.CDAC_ID like \'CDACN/VM/%\' OR hw.CDAC_ID like \'CDACN/CVM/%\' AND Status = 1
            group by Type';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'Dashboard');
            $this->dataset->addFields(
                array(
                    new StringField('Type', false, true),
                    new IntegerField('Total', false, true)
                )
            );
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
            $sql = 'select Concat(t.Name, \': Approval\') as Status_For, ChangeReq_By, count(*) as Total from iso_internal_change_mgmt  i
            left join mst_team t on (t.id = i.Team)
            where i.Approved = 0
            group by t.name
            UNION
            select Concat(t.Name,\': Action\') as Status_For, ChangeReq_By, count(*) as Total from iso_internal_change_mgmt  i
            left join mst_team t on (t.id = i.Team)
            where i.Done = 0
            group by t.name
            UNION
            select Concat(t.Name,\': Verify\') as Status_For, ChangeReq_By, count(*) as Total from iso_internal_change_mgmt  i
            left join mst_team t on (t.id = i.Team)
            where i.Verified = 0
            group by ChangeReq_By
            Order by Status_For';
            $chart = new Chart('ChangeMgmt01', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Change Management Pending Status');
            $chart->setDomainColumn('Status_For', 'Status_For', 'string');
            $chart->addDataColumn('Total', 'Total (Qty)', 'int')
                ->setAnnotationColumn('ChangeReq_By')
                ->setAnnotationTextColumn('Total');
            $this->addChart($chart, 0, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'SELECT t.Name as Team,cp.Name as Name, count(*) as Total FROM rec_access_rights acc
            left join contact_person cp on (cp.id = acc.given_by)
            left join mst_team t on (t.id = cp.team)
            where status = 4 and End_Date < now()
            group by cp.name';
            $chart = new Chart('Access01', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Access Revoke Pending');
            $chart->setDomainColumn('Name', 'Name', 'string');
            $chart->addDataColumn('Total', 'Total (Qty)', 'int')
                ->setAnnotationColumn('Team')
                ->setAnnotationTextColumn('Total');
            $this->addChart($chart, 1, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'select Person_Name,  Concat(
            format(floor(sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            )
            )/86400,0) , \' Days \',  
            
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            		)
            	),\'%H\'
            ), 24
            ) ,\' Hrs. \',
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            		)
            	),\'%i\'
            ), 60
            ),\' Min.\' )as Work_Duration, 
            sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            )
             as Work_in_Sec
            from offhour_work_details 
            where From_DateTime BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE()
            group by Person_Name;';
            $chart = new Chart('Working02', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Extra Working Hrs (Last 90 Days)');
            $chart->setDomainColumn('Person_Name', 'Person_Name', 'string');
            $chart->addDataColumn('Work_in_Sec', 'Work (Sec)', 'int')
                ->setAnnotationColumn('Work_Duration')
                ->setAnnotationTextColumn('Work_in_Sec');
            $this->addChart($chart, 2, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'select Person_Name,  Concat(
            format(floor(sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            )
            )/86400,0) , \' Days \',  
            
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            		)
            	),\'%H\'
            ), 24
            ) ,\' Hrs. \',
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            		)
            	),\'%i\'
            ), 60
            ),\' Min.\' )as Work_Duration, 
            sum((TIMESTAMPDIFF(day,From_DateTime,To_DateTime)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,From_DateTime,To_DateTime), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,From_DateTime,To_DateTime), 60)*60)
            )
             as Work_in_Sec
            from offhour_work_details 
            where From_DateTime BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            group by Person_Name;';
            $chart = new Chart('Working01', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Extra Working Hrs (Last 30 Days)');
            $chart->setDomainColumn('Person_Name', 'Person_Name', 'string');
            $chart->addDataColumn('Work_in_Sec', 'Work (Sec)', 'int')
                ->setAnnotationColumn('Work_Duration')
                ->setAnnotationTextColumn('Work_in_Sec');
            $this->addChart($chart, 3, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'select \'Backup Scheduled\' as Qty_For, count(*) as Total from rpt_bkp_scheduled
            UNION
            SELECT \'Backup not Scheduled\' as Qty_For, count(*) as Total FROM dcapp.rpt_bkp_not_scheduled_prd';
            $chart = new Chart('Backup01', Chart::TYPE_PIE, $this->dataset, $sql);
            $chart->setTitle('Backup not Scheduled');
            $chart->setDomainColumn('Qty_For', 'Qty_For', 'string');
            $chart->addDataColumn('Total', '', 'int')
                ->setAnnotationColumn('Qty_For')
                ->setAnnotationTextColumn('Total');
            $this->addChart($chart, 4, ChartPosition::BEFORE_GRID, 10);
            
            $sql = 'select Concat(p.Name,\'-\' , a.name) as Project,  count(i.issue) as Total,  Concat(
            format(floor(sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            )
            )/86400,0) , \' Days \',  
            
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            		)
            	),\'%H\'
            ), 24
            ) ,\' Hrs. \',
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            		)
            	),\'%i\'
            ), 60
            ),\' Min.\' )as Work_Duration, 
            sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            )
             as Work_in_Sec
             
             from sw_downtime_rp d
             join project_app app on app.id = d.application
            join mst_application_name a on a.id = app.Application
            join project p on p.id = app.Project
            join mst_issues i on i.id = d.issue
            where i.Issue like \'%patch%\' AND
                  Down_Date_Time BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            group by a.name
            order by Work_Duration';
            $chart = new Chart('Downtime01', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Application Downtime (Last 30 Days)');
            $chart->setDomainColumn('Work_Duration', 'Work_Duration', 'string');
            $chart->addDataColumn('Work_in_Sec', 'Total (Sec)', 'int')
                ->setAnnotationColumn('Project')
                ->setAnnotationTextColumn('Work_in_Sec');
            $this->addChart($chart, 5, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'select Concat(p.Name,\'-\' , a.name) as Project,  count(i.issue) as Total,  Concat(
            format(floor(sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            )
            )/86400,0) , \' Days \',  
            
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            		)
            	),\'%H\'
            ), 24
            ) ,\' Hrs. \',
            MOD(time_format(
            sec_to_time(
            	sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            		(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            		(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            		)
            	),\'%i\'
            ), 60
            ),\' Min.\' )as Work_Duration, 
            sum((TIMESTAMPDIFF(day,Down_Date_Time,Up_Date_Time)*24*60*60) + 
            	(MOD( TIMESTAMPDIFF(hour,Down_Date_Time,Up_Date_Time), 24)*60*60) + 
            	(MOD( TIMESTAMPDIFF(minute,Down_Date_Time,Up_Date_Time), 60)*60)
            )
             as Work_in_Sec
             
             from sw_downtime_rp d
             join project_app app on app.id = d.application
            join mst_application_name a on a.id = app.Application
            join project p on p.id = app.Project
            join mst_issues i on i.id = d.issue
            where i.Issue like \'%patch%\' AND
                  Down_Date_Time BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            group by a.name
            order by Total';
            $chart = new Chart('Downtime02', Chart::TYPE_LINE, $this->dataset, $sql);
            $chart->setTitle('Application Patches (Last 30 Days)');
            $chart->setDomainColumn('Project', 'Project', 'string');
            $chart->addDataColumn('Total', 'Total Patches', 'int')
                ->setAnnotationTextColumn('Total');
            $this->addChart($chart, 6, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'select  \'Physical Servers\' as Type, count(*) as Total from hw_details hw 
            where hw.CDAC_ID like \'CDACN/SVR/%\' AND Status = 1 
            group by Type
            UNION
            select  \'Virtual Servers\' as Type, count(*) as Total from hw_details hw 
            where hw.CDAC_ID like \'CDACN/VM/%\' OR hw.CDAC_ID like \'CDACN/CVM/%\' AND Status = 1
            group by Type';
            $chart = new Chart('Hardware01', Chart::TYPE_PIE, $this->dataset, $sql);
            $chart->setTitle('Physical vs Virtual');
            $chart->setDomainColumn('Type', 'Type', 'string');
            $chart->addDataColumn('Total', 'Total', 'int')
                ->setAnnotationColumn('Total');
            $this->addChart($chart, 7, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'select tb2.Status as Status, count(*) as Total from hw_details hw
            LEFT JOIN mst_hw_status tb2 on (tb2.id = hw.status)
            where hw.CDAC_ID like \'CDACN/SVR/%\'
            group by tb2.status';
            $chart = new Chart('Hardware02', Chart::TYPE_PIE, $this->dataset, $sql);
            $chart->setTitle('Physical Server Status');
            $chart->setDomainColumn('Status', 'Status', 'string');
            $chart->addDataColumn('Total', 'Total', 'int')
                ->setAnnotationColumn('Status')
                ->setAnnotationTextColumn('Total');
            $this->addChart($chart, 8, ChartPosition::BEFORE_GRID, 5);
            
            $sql = 'select tb2.Make_Model as Model, count(*) as Total from hw_details hw 
            LEFT JOIN mst_hw_make_model tb2 on (tb2.id = hw.Make_Model)
            where hw.CDAC_ID like \'CDACN/SVR%\' AND Status != 5
            group by tb2.Make_Model';
            $chart = new Chart('Hardware03', Chart::TYPE_PIE, $this->dataset, $sql);
            $chart->setTitle('Model');
            $chart->setDomainColumn('Model', 'Model', 'string');
            $chart->addDataColumn('Total', 'Total', 'int')
                ->setAnnotationColumn('Model')
                ->setAnnotationTextColumn('Total');
            $this->addChart($chart, 9, ChartPosition::BEFORE_GRID, 12);
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'Type', 'Type', 'Type'),
                new FilterColumn($this->dataset, 'Total', 'Total', 'Total')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
    
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
    
        }
    
        protected function AddEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
    
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
    
        }
    
        protected function AddExportColumns(Grid $grid)
        {
    
        }
    
        private function AddCompareColumns(Grid $grid)
        {
    
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
            
            $result->SetUseImagesForActions(false);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->setAllowSortingByClick(false);
            $result->setAllowSortingByDialog(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->SetShowUpdateLink(false);
            $result->setAllowAddMultipleRecords(false);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
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
            $this->setPrintListAvailable(false);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(false);
            $this->setAllowPrintSelectedRecords(false);
            $this->setExportListAvailable(array());
            $this->setExportSelectedRecordsAvailable(array());
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array());
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
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
        $Page = new DashboardPage("Dashboard", "Dashboard.php", GetCurrentUserPermissionsForPage("Dashboard"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("Dashboard"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
