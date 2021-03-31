<template>
    <div id="bank_account">
        <div class="container-fluid p-5">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h4 class="text-uppercase font-weight-bold">Bank Accounts</h4>
                </div>
                <div class="col-md-6 text-right">
                    <el-button type="primary" icon="el-icon-plus" plain size="small" @click="bankModalOpen">Create</el-button>
                </div>
            </div>

            <div class="mt-4">
                <el-table ref="multipleTable" :data="bank_accounts.data" style="width: 100%" @selection-change="handleSelectionChange">
                    <el-table-column property="account_name" label="Account Name" width="310"></el-table-column>
                    <el-table-column property="financial_organization.name" label="Bank" width="310"></el-table-column>
                    <el-table-column property="account_no" label="Account No" width="310"></el-table-column>
                    <el-table-column property="branch" label="Branch" width="310"></el-table-column>

                    <el-table-column v-if="account_type == 1" property="account_type" label="Account Type" width="310">Savings Account</el-table-column>
                    <el-table-column v-else-if="account_type == 2" property="account_type" label="Account Type" width="310">Current Account</el-table-column>
                    <el-table-column v-else property="account_type" label="Account Type" width="310">Joint Account</el-table-column>


                    <el-table-column label="Actions">
                        <template slot-scope="scope">
                            <el-button size="mini" icon="el-icon-edit" @click.prevent="editBankAccount(scope.row)">Edit</el-button>
                            <el-button size="mini" icon="el-icon-delete" type="danger" @click.prevent="deleteBankAccount(scope.row.id)">Delete</el-button>
                        </template>
                    </el-table-column>
                </el-table>

                <el-pagination class="text-center mt-3"
                               background
                               @current-change="paginationChange"
                               :current-page.sync="currentPage"
                               :page-size="bank_accounts.per_page"
                               layout="prev, pager, next"
                               :total="bank_accounts.total">
                </el-pagination>
            </div>


            <!-- Create Bank Account Modal Start -->
            <el-dialog
                :title= "form.id ? 'Update Bank Account' : 'Create Bank Account'"
                :visible.sync="bankAccountCreateModal"
                width="50%"
            >
            <span>
                <el-form>
                    <el-form-item label="Name *">
                        <el-input v-model="form.account_name" placeholder="Enter Account Name"></el-input>
                        <span class="text-danger" v-if="errors['account_name']">{{ errors['account_name'][0] }}</span>
                    </el-form-item>

                    <el-form-item label="Bank *">
                        <el-select v-model="form.financial_organization_id" placeholder="Please Select Bank">
                            <template v-for="bank in banks">
                                <el-option :key="bank.id" :label="bank.name" :value="bank.id"></el-option>
                            </template>
                        </el-select>
                        <span class="text-danger" v-if="errors['financial_organization_id']">{{ errors['financial_organization_id'][0] }}</span>
                    </el-form-item>

                    <el-form-item label="Account No *">
                        <el-input v-model="form.account_no" placeholder="Enter Account No"></el-input>
                        <span class="text-danger" v-if="errors['account_no']">{{ errors['account_no'][0] }}</span>
                    </el-form-item>

                    <el-form-item label="Branch *">
                        <el-select v-model="form.branch" placeholder="Please Select Branch">
                            <el-option value="Gulshan">Gulsan</el-option>
                            <el-option value="Dhanmondi">Dhanmondi</el-option>
                            <el-option value="Badda">Badda</el-option>
                            <el-option value="Kallyanpur">Kallyanpur</el-option>
                        </el-select>
                        <span class="text-danger" v-if="errors.branch">{{ errors.branch[0] }}</span>
                    </el-form-item>

                    <el-form-item label="Account Type *">
                        <el-select v-model="form.account_type" placeholder="Please Select Account Type">
                            <el-option value="1">Savings Account</el-option>
                            <el-option value="2">Current Account</el-option>
                            <el-option value="3">Joint Account</el-option>
                        </el-select>
                        <span class="text-danger" v-if="errors.account_type">{{ errors.account_type[0] }}</span>
                    </el-form-item>

                    <el-form-item label="Swift Code *">
                        <el-input v-model="form.swift_code" placeholder="Enter Swift Code"></el-input>
                        <span class="text-danger" v-if="errors['swift_code']">{{ errors['swift_code'][0] }}</span>
                    </el-form-item>

                    <el-form-item label="Route No *">
                        <el-input v-model="form.route_no" placeholder="Enter Route No"></el-input>
                        <span class="text-danger" v-if="errors['route_no']">{{ errors['route_no'][0] }}</span>
                    </el-form-item>
                </el-form>
            </span>
                <span slot="footer" class="dialog-footer">
                <el-button @click="bankAccountList">Cancel</el-button>
                <el-button type="primary" v-if="!form.id" @click="createBankAccount">Create</el-button>
                <el-button type="primary" v-else @click="updateBankList">Update</el-button>
            </span>
            </el-dialog>
            <!-- Create Bank Account Modal End -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "BankAccount",
        data(){
            return{
                form:{},
                errors:{},
                currentPage:1,
                bankAccountCreateModal: false,
                account_type: '',
            }
        },
        methods: {
            bankModalOpen(){
                this.bankAccountCreateModal = true
            },
            paginationChange(){
                this.$store.dispatch('bankAccountList', this.currentPage)
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            bankAccountList(){
                this.bankAccountCreateModal = false
                this.$store.dispatch('bankAccountList', this.currentPage)
            },
            bankList(){
                this.$store.dispatch('bankList')
            },
            createBankAccount(){
                axios.post('/api/bank-account', this.form)
                    .then((result) => {
                        this.bankAccountCreateModal = false;
                        this.bankAccountList();
                        this.form = {},
                        this.$message({
                            showClose: true,
                            message: 'Bank Account Created successfully.',
                            type: 'success'
                        });
                    }).catch((error) => {
                    this.errors = error.response.data.errors
                });
            },
            updateBankList(){
                axios.put('/api/bank-account/'+this.form.id, this.form)
                    .then((result) => {
                        this.bankAccountCreateModal = false;
                        this.bankAccountList();
                        this.$message({
                            showClose: true,
                            message: 'Bank Account Updated successfully.',
                            type: 'success'
                        });
                    }).catch((error) => {
                    this.errors = error.response.data.errors
                });
            },
            editBankAccount(bank_account){
                this.bankAccountCreateModal = true
                this.errors = {}
                this.form = bank_account
            },
            deleteBankAccount(id){
                axios.delete(`/api/bank-account/${id}`)
                    .then((result) => {
                        this.bankAccountList();
                        this.$message({
                            showClose: true,
                            message: 'Bank Account Deleted successfully.',
                            type: 'success'
                        });
                    }).catch((error) => {

                });
            }
        },
        computed:{
            bank_accounts(){
                return this.$store.getters.bankAccountList;
            },
            banks(){
                return this.$store.getters.bankList;
            }
        },
        created() {
            this.bankAccountList();
            this.bankList();
        }
    }
</script>

<style scoped>

</style>
