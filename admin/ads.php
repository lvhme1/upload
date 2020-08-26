<?php
require("core.php");
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `ads` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-bullhorn"></i> Ads</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Ads</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
	$position = $_POST['position'];
    $code     = addslashes(htmlentities($_POST['code']));
    
    $queryvalid = mysqli_query($connect, "SELECT * FROM `ads` WHERE code='$code' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Ad</strong> is already added.</p>
        </div>
		';
    } else {
        
        $query = mysqli_query($connect, "INSERT INTO `ads` (position, code) VALUES('$position', '$code')");
    }
}
?>
                    
                <div class="row">
				<div class="col-md-7">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `ads` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=ads.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=ads.php">';
    }
    
    if (isset($_POST['edit'])) {
		$position = $_POST['position'];
        $code     = addslashes(htmlentities($_POST['code']));
        
        $queryvalid = mysqli_query($connect, "SELECT * FROM `ads` WHERE code='$code' AND id != '$id' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Ad</strong> is already added.</p>
        </div>';
        } else {
            
            $query = mysqli_query($connect, "UPDATE `ads` SET position='$position', code='$code' WHERE id='$id'");
            echo '<meta http-equiv="refresh" content="0; url=ads.php">';
        }
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Ad</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-2 control-label">Position: </label>
											<div class="col-sm-10">
	<select name="position" class="form-control" required>
        <option value="Header" <?php
    if ($row['position'] == 'Header') {
        echo 'selected';
    }
?>>Header</option>
        <option value="Footer" <?php
    if ($row['position'] == 'Footer') {
        echo 'selected';
    }
?>>Footer</option>
    </select>
	                                         </div>
										</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Content (HTML Supported): </label>
											<div class="col-sm-10">
												<textarea name="code" class="form-control" id="summernote" rows="8" required><?php
    echo $row['code'];
?></textarea>
											</div>
								</div>
                        </div>
                        <div class="panel-footer">
							<button class="btn btn-flat btn-success" name="edit" type="submit">Save</button>
				            <button type="reset" class="btn btn-flat btn-default">Reset</button>
				        </div>
				     </div>
</form>
<?php
}
?>
				
				    <div class="box">
						<div class="box-header">
							<h3 class="box-title">Ads</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Ad</th>
											<th>Position</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `ads`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>Ad #' . $row['id'] . '</td>
											<td>' . $row['position'] . '</td>
											<td>
                                            <a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-danger"><i class="fas fa-trash"></i> Delete</a>
											</td>
										</tr>
';
}
?>
									</tbody>
								</table>
                        </div>
                     </div>
                </div>
                    
				<div class="col-md-5">
<form class="form-horizontal" action="" method="post">
				     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Add Ad</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-4 control-label">Position: </label>
											<div class="col-sm-8">
	<select name="position" class="form-control" required>
        <option value="Header" selected>Header</option>
        <option value="Footer">Footer</option>
    </select>
											</div>
										</div>
								<div class="form-group">
											<label class="col-sm-12">Content (HTML Supported): </label><br />
											<div class="col-sm-12">
												<textarea class="form-control" id="summernote" name="code" rows="8" required></textarea>
											</div>
							    </div>
                        </div>
                        <div class="panel-footer">
							<button class="btn btn-flat btn-primary" name="add" type="submit">Add</button>
							<button type="reset" class="btn btn-flat btn-default">Reset</button>
				        </div>
				     </div>
</form>

				</div>
				</div>
                    
				</div>
				<!--===================================================-->
				<!--End page content-->


			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->

<script>
$(document).ready(function() {

	$('#summernote').summernote({
        height: 250
    });
	$('#summernote2').summernote({
        height: 250
    });

	$('#dt-basic').dataTable( {
		"responsive": true,
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
} );
</script>
<?php
footer();
?>