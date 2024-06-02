<?php include '../assets/includes/header.php'; ?>
<!-- DIRECTORY -->
<div class="main-dir">
	<h1>Classes</h1>
</div>
<!-- END DIRECTORY -->

<!-- CONTAINER -->
<div class="main-container">
	<div class="inner-container">
		<div class="content-row">
			<div class="panel back-color-white">
				<div class="panel-header-norm">
					<h2>Classes</h2>
					<a href="classes-student.php"><button class="button-header back-color-rb">Add
							Class</button></a>
				</div>
				<div>

				</div>
				<div class="panel-content-norm">
					<table class="action-table" id="classTable">
						<tr>
							<th>Class Code</th>
							<th>Course</th>
							<th>Instructor</th>
							<th>School Year</th>
							<th>Action</th>
						</tr>
						<?php $el->getClassesStudent($user); ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END CONTAINER -->
<?php include '../assets/includes/footer.php'; ?>