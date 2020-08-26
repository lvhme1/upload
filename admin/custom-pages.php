<?php
require("core.php");
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $query = mysqli_query($connect, "DELETE FROM `custom_pages` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				<section class="content-header">
    			  <h1><i class="fas fa-columns"></i> Custom Pages</h1>
    			  <ol class="breadcrumb">
   			         <li><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
    			     <li class="active">Custom Pages</li>
    			  </ol>
    			</section>


				<!--Page content-->
				<!--===================================================-->
				<section class="content">

<?php
if (isset($_POST['add'])) {
    $title   = addslashes($_POST['title']);
    $content = addslashes(htmlentities($_POST['content']));
    $fa_icon = addslashes($_POST['fa-icon']);
    $logged  = addslashes($_POST['logged']);
    
    $queryvalid = mysqli_query($connect, "SELECT * FROM `custom_pages` WHERE title='$title' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Page</strong> is already added.</p>
        </div>
		';
    } else {
        
        $query = mysqli_query($connect, "INSERT INTO `custom_pages` (title, content, fa_icon, logged) VALUES('$title', '$content', '$fa_icon', '$logged')");
    }
}
?>
                    
                <div class="row">
				<div class="col-md-7">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `custom_pages` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=custom-pages.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=custom-pages.php">';
    }
    
    if (isset($_POST['edit'])) {
        $title   = addslashes($_POST['title']);
        $content = addslashes(htmlentities($_POST['content']));
        $fa_icon = addslashes($_POST['fa-icon']);
        $logged  = addslashes($_POST['logged']);
        
        $queryvalid = mysqli_query($connect, "SELECT * FROM `custom_pages` WHERE title='$title' AND id != '$id' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>Page</strong> is already added.</p>
        </div>';
        } else {
            
            $query = mysqli_query($connect, "UPDATE `custom_pages` SET title='$title', content='$content', fa_icon='$fa_icon', logged='$logged' WHERE id='$id'");
            echo '<meta http-equiv="refresh" content="0; url=custom-pages.php">';
        }
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Custom Page</h3>
						</div>
				        <div class="box-body">
								<div class="form-group">
											<label class="col-sm-2 control-label">Page Title: </label>
											<div class="col-sm-10">
												<input type="text" name="title" class="form-control" value="<?php
    echo $row['title'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Font Awesome Icon: </label>
											<div class="col-sm-10">
												<input type="text" name="fa-icon" class="form-control" value="<?php
    echo $row['fa_icon'];
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Login Required: </label>
											<div class="col-sm-10">
	<select name="logged" class="form-control" required>
        <option value="No" <?php
    if ($row['logged'] == 'No') {
        echo 'selected';
    }
?>>No</option>
        <option value="Yes" <?php
    if ($row['logged'] == 'Yes') {
        echo 'selected';
    }
?>>Yes</option>
    </select>
	                                         </div>
										</div>
								<div class="form-group">
											<label class="col-sm-2 control-label">Content (HTML Supported): </label>
											<div class="col-sm-10">
												<textarea name="content" class="form-control" id="summernote2" rows="16" required><?php
    echo $row['content'];
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
							<h3 class="box-title">Custom Pages</h3>
						</div>
						<div class="box-body">
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Page Title</th>
											<th>Login Required</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = mysqli_query($connect, "SELECT * FROM `custom_pages`");
while ($row = mysqli_fetch_assoc($query)) {
    echo '
										<tr>
											<td>' . $row['id'] . '</td>
											<td>' . $row['title'] . '</td>
											<td>' . $row['logged'] . '</td>
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
							<h3 class="box-title">Add Custom Page</h3>
						</div>
				        <div class="box-body">					
								<div class="form-group">
											<label class="col-sm-4 control-label">Page Title: </label>
											<div class="col-sm-8">
												<input type="text" name="title" class="form-control" required>
											</div>
							    </div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Font Awesome Icon: </label>
											<div class="col-sm-8">
												<input type="text" name="fa-icon" class="form-control" placeholder="fa-male" required>
											</div>
								</div>
								<div class="form-group">
											<label class="col-sm-4 control-label">Login Required: </label>
											<div class="col-sm-8">
	<select name="logged" class="form-control" required>
        <option value="No" selected>No</option>
        <option value="Yes">Yes</option>
    </select>
											</div>
										</div>
								<div class="form-group">
											<label class="col-sm-12">Content (HTML Supported): </label><br />
											<div class="col-sm-12">
												<textarea class="form-control" id="summernote" name="content" rows="16" required></textarea>
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
        height: 400
    });
	$('#summernote2').summernote({
        height: 400
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