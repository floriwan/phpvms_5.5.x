
<h3><?php echo SITE_NAME;?> Staff Team</h3>
<table id="tabledlist" class="tablesorter">
<?php
if(!$stafflevels)
{
echo 'There is no staff!';
$stafflevels = array();
}
foreach($stafflevels as $level)
{
?>
<thead>
    <tr>
        <th colspan="3"><?php echo $level->name;?></th>
    </tr>
</thead>
<tbody>
    <?php
    $allstaff = vStaffListData::GetAllStaffInCat($level->id);
        if(!$allstaff)
        {
        $allstaff = array();
        echo '<tr class="row0"><td align="center" colspan="3">No Staff Members</td></tr>';
        }
        foreach($allstaff as $staff)
        {
    ?>
	<tr>
    <td align="center"><?php if($staff->pilotid == 0)
    					{
                        	echo 'VACANT';
                        }
                        else
                        {
                        	echo '<a href="'.url('vStaff/view/'.$staff->id).'">'.$staff->firstname.' '.$staff->lastname.'</a>';
                        }
                        ?></td>
	<td align="center"><?php echo $staff->title;?></td>
    <td align="center"><?php echo $staff->email;?></td>
	</tr>
	<?php
    }
    ?>
<?php
}
?>
</tbody>
</table>
