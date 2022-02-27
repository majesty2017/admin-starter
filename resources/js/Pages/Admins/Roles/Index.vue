<template>
    <Head title="Roles"/>
    <admin-layout>
        <template #header>
        <h2 class="h4 font-weight-bold">
            Roles
        </h2>
    </template>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles & Permissions</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary text-uppercase" style="letter-spacing: 0.em" @click="openModal">Add New</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Role</th>
                        <th>Permission</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(role, index) in roles" :key="index">
                        <td>{{ role.name }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <span v-for="(permission, index) in role.permissions" :key="index">
                                    {{ permission.name }}
                                </span>
                            </div>
                        </td>
                        <td>{{ role.created_at }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info">Action</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-edit text-primary"></i> Edit Role</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-trash text-danger"></i> Delete Role</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="modal fade" id="addModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Role</h4>
                        <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="h4 ml-3">
                            <span>Preview: <span class="text-capitalize">{{ form.name }}</span></span>
                        </div>
                        <form @submit.prevent="createRole">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="role">Role Name</label>
                                    <input type="text" v-model="form.name" class="form-control" id="role"
                                           placeholder="Role Name" autofocus="autofocus" autocomplete="off"
                                           :class="{ 'is-invalid': form.errors.name }">
                                </div>
                                <div class="invalid-feedback mb-3" :class="{'d-block': form.errors.name }">{{ form.errors.name }}</div>

                                <div class="form-group">
                                    <label>Permission</label>
                                    <multiselect
                                     v-model="form.permissions"
                                     :options="permissionOptions"
                                     :multiple="true"
                                     :taggable="true"
                                     placeholder="Choose permission(s)"
                                     @addPermissions="addPermissions"
                                     label="name"
                                     track-by="id"
                                    ></multiselect>
                                </div>
                                <div class="invalid-feedback mb-3" :class="{'d-block': form.errors.permissions }">{{ form.errors.permissions }}</div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer justify-content-between">
                                <button type="button" class="btn btn-danger" @click="closeModal">Cancel</button>
                                <button type="submit" class="btn btn-primary float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </admin-layout>
</template>

<script>
$(document).ready((function () {

}))
import AdminLayout from "@/Layouts/AdminLayout";
import {Head} from "@inertiajs/inertia-vue3";
export default {
    props: ['roles', 'permissions'],
    components: {
        AdminLayout,
        Head,
    },
    data() {
        return {
            form: this.$inertia.form({
                id: '',
                name: '',
                permissions: []
            }),
            permissionOptions: this.permissions,
        }
    },
    methods: {
        createRole() {
          this.form.post(this.route('admin.roles.store'), {
              preserveScroll: true,
              onSuccess: () => {
                  this.form.reset()
                  this.closeModal()
                  this.toastAlert('success', 'Role saved successfully')
              }
          })
        },
        addPermissions(newPermission) {
            let permission = {
                name: newPermission
            }
            this.permissionOptions.push(permission)
            this.form.permissions.push(permission)
        },
        openModal() {
            $('#addModal').modal('show')
        },
        closeModal() {
            $('#addModal').modal('hide')
        },
        toastAlert(status, msg) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: status,
                title: msg
            })
        },

        alertDelete(id, url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mr-2'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your record has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your record is safe :)',
                        'error'
                    )
                }
            })
        },
    },
    mounted() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "paging": true,
            "ordering": true,
            "info": true,
            'lengthMenu': [
                [10, 25, 50, 100, 250, -1],
                [10, 25, 50, 100, 250, "All"],
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    },
}
</script>

<style scoped>

</style>
