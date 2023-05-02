<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"><?= $title ?></h1>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							Access Management
						</h3>
					</div>
					<div class="card-body pad table-responsive">
						<table class="table table-bordered table-sm dt-responsive nowrap" id="myData" width="100%">
							<thead>
								<tr>
									<th>Role</th>
									<?php foreach ($menus as $menu) : ?>
										<th width="20%"><?= $menu->title ?></th>
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody id="data">
								<?php foreach ($roles as $role) : ?>
									<tr>
										<th><?= $role->role ?></th>
										<?php foreach ($menus as $menu) : ?>
											<td>
												<input type="checkbox" class="cek" data-id_role="<?= $role->id_role ?>" data-id_menu="<?= $menu->id_menu ?>" <?= $permission[$role->id_role][$menu->id_menu];?>>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
