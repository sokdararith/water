<div id="menu">
    <div class="btn-group">
        <a class="btn" href="<?php echo base_url(); ?>hr" id="newStaff"><i class="icon-home"></i></a>
    </div>
    <div class="btn-group">
        <?php echo anchor('hr/addEmployee', 'New Staff', array('class'=>'btn')); ?>
        <?php echo anchor('hr/credential', 'Credential', array('class'=>'btn')); ?>
    </div>
    <div class="btn-group">
        <?php echo anchor('hr/nationality', 'Nationality', array('class'=>'btn')); ?>
        <?php echo anchor('hr/department', 'Department', array('class'=>'btn')); ?>
        <?php echo anchor('hr/job', 'Job', array('class'=>'btn')); ?>
    </div>
    <div class="btn-group">
        <?php echo anchor('hr/salary', 'Salary', array('class'=>'btn')); ?>
        <?php echo anchor('hr/payroll_list', 'Payroll', array('class'=>'btn')); ?>
        <?php echo anchor('activity', 'Timesheet', array('class'=>'btn')); ?>
    </div>              
</div><br>