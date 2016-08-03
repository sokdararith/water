<div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row-fluid row-merge widget-tabs-gray">

    <!-- Tabs Heading -->
    <div class="widget-head span3 hidden-print">
        <ul>
            <li class="active"><a href="#tab1-1" class="glyphicons user" data-toggle="tab"><i></i><span class="strong">Step 1</span><span>មធ្យោបាយផលិតកម្ម</span></a>
            </li>
            <li><a href="#tab2-1" class="glyphicons calculator" data-toggle="tab"><i></i><span class="strong">Step 2</span><span>ថាមពលផលិត</span></a>
            </li>
            <li><a href="#tab3-1" class="glyphicons credit_card" data-toggle="tab"><i></i><span class="strong">Step 3</span><span>មធ្យោបាយចែកចាយ</span></a>
            </li>
            <li><a href="#tab4-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 4</span><span>ព័ត៌មានលម្អិតតាមតរង់ស្វូ</span></a>
            </li>
            <li><a href="#tab5-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 5</span><span>ព័ត៌មានពំពីអតិថិជនជាអ្នកប្រើប្រាស់ផ្ទាល់</span></a>
            </li>
            <li><a href="#tab6-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 6</span><span>អតិថិជនកាន់អាជ្ញាប័ណ្ណ</span></a>
            </li>
            <li><a href="#tab7-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 7</span><span>ព័ត៌មានការលក់ថាមពលអោយអ្នកប្រើប្រាស់ផ្ទាល់</span></a>
            </li>
            <li><a href="#tab8-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 8</span><span>ព័ត៌មានថាមពលលក់អោយអ្នកកាន់អាជ្ញាប័ណ្ណ</span></a>
            </li>
            <li><a href="#tab9-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 9</span><span>ព័ត៌មានប្រភពទិញថាមពល</span></a>
            </li>
            <li><a href="#tab10-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 10</span><span>ព័ត៌មានអំពីការទិញថាមពល</span></a>
            </li>
            <li><a href="#tab11-1" class="glyphicons circle_ok" data-toggle="tab"><i></i><span class="strong">Step 11</span><span>តំបន់ចែកចាយក្នុងអាជ្ញាប័ណ្ណ</span></a>
            </li>
        </ul>
    </div>
    <!-- // Tabs Heading END -->

    <div class="widget-body span9">
        <div class="tab-content">

            <!-- Tab content -->
            <div class="tab-pane active" id="tab1-1">
                <h4>មធ្យោបាយផលិតកម្ម</h4>
                <div id="generationFacility"></div>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab2-1">
                <h4>dsfds</h4>	
                <div id="generatorRecords"></div>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab3-1">
                <h4>មធ្យោបាយចែកចាយ</h4>
                	<table class="table table-condensed table-hover" id="distribution">
						<thead>
							<tr>
								<th width="120">មធ្យោបាយចែកចាយ</th>
								<th>តង់ស្យុងផ្គត់ផ្គង់(kV)</th>
								<th>ចំនួនហ្វា</th>
								<th>ប្រវែងខ្សែ(សៀគ្វីម៉ែត្រ)</th>
								<th>ថ្ងៃចាប់ផ្ដើមប្រើ</th>
								<th>ថ្ងៃឈប់ប្រើ</th>
								<th width="35"></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab4-1">
                <h4>ព័ត៌មានលម្អិតតាមតរង់ស្វូ</h4>
                <table id="transformers">
                	<tbody></tbody>
                </table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab5-1">
                <h4>5 tab</h4>
                <div id="customerSegment"></div>
            </div>
            <!-- // Tab content END -->

			<!-- Tab content -->
            <div class="tab-pane" id="tab6-1">
                <h4 class="printTitle">ព័ត៌មានអំពីអតិថិជនជាអ្នកកាន់អាជ្ញាប័ណ្ណ</h4>
				<table class="table" id="licensees">
					<thead>
						<tr>
							<td>អាជ្ញាប័ណ្ណ</td>
							<td>ឈ្មោះអ្នកកាន់អាជ្ញាប័ណ្ណ</td>
							<td>លេខអតិថិជន</td>
							<td>ទីតាំង</td>
							<td>តង់ស្យុង</td>
							<td>បញ្ជីថ្លៃលក់</td>
							<td>ចំនួនភ្ជាប់</td>
							<td><a href="#/licensees/create" class="menu"><?=$this->lang->line('button_create'); ?></a></td>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
                
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab7-1">
                <h4>7 tab</h4>
                
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab8-1">
                <h4>8 tab</h4>
                
            </div>
			<!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab9-1">
                <h4>ប្រភពទិញថាមពល</h4>
                <table class="table" id="energySourcePurchased">
					<tbody></tbody>
				</table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab10-1">
                <h4>ប្រភពទិញថាមពល</h4>
                <table class="table" id="energyPurchased">
					<tbody></tbody>
				</table>
            </div>
            <!-- // Tab content END -->

            <!-- Tab content -->
            <div class="tab-pane" id="tab11-1">
                <h4>11</h4>
                <div id="distributionAreas"></div>
            </div>
            <!-- // Tab content END -->
            
        </div>

    </div>
</div>