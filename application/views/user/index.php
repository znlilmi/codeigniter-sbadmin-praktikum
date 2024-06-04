<main>
     <div class="container-fluid px-4">
         <h1 class="mt-4">2210010415 - Muhammad Zainal Ilmi</h1>
         <ol class="breadcrumb mb-4">
             <li class="breadcrumb-item"><a href="<?php echo site_url('admin/user') ?>">User</a></li>
             <li class="breadcrumb-item active "><?php echo $title; ?></li>
         </ol>
         <div class="card mb-4">
             <div class="card-header">
                 <a href="<?php echo site_url('admin/user/add') ?>"><i class="fas fa-plus"></i>Add New</a>
             </div>
             <?php if ($this->session->flashdata('success')) : ?>
                 <div class="alert alert-success" role="alert">
                     <?php $this->session->flashdata('success') ?>
                 </div>
             <?php endif; ?>
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover" id="tabel-kelas" width="100%" cellspacing="0">
                         <thead>
                             <tr>
                                 <th>No</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Phone</th>
                                 <th>Role</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($user as $user) {
                                ?>
                                 <tr>
                                     <td><?php echo $no; ?></td>
                                     <td><?php echo $user->username; ?></td>
                                     <td><?php echo $user->email; ?></td>
                                     <td><?php echo $user->phone; ?></td>
                                     <td><?php echo $user->role; ?></td>
                                     <td>
                                         <div>
                                             <a href="<?php echo base_url('admin/user/getedit/' . $user->id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                                             <a href="<?php echo base_url('admin/user/delete/' . $user->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ingin menghapus data user ini?');">
                                                 <i class="fas fa-trash"></i> Hapus
                                             </a>
                                         </div>
                                     </td>
                                 </tr>
                             <?php
                                    $no++;
                                }
                                ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

         <div class="vh-100 "></div>
     </div>
 </main>