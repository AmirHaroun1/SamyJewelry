<template>
    <div class="container py-25">
        <div class="card card-custom">
            <div class="card-body p-0">
                <!--begin::Wizard-->
                <div class="wizard wizard-1" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="false">
                    <!--begin::Wizard Nav-->
                    <div class="wizard-nav border-bottom">
                        <div class="wizard-steps p-8 p-lg-10">
                            <!--begin::Wizard Step 1 Nav-->
                            <!--------- if the employee id equal 1 it means 'batreena' no one could edit it -------->
                            <div v-if="ActiveTap == 'Employee-info' || ( Employee != undefined && Employee.id !=1 )" class="wizard-step cursor-pointer" data-wizard-type="step" @click="ActiveTap = 'Employee-info'" :data-wizard-state="ActiveTap == 'Employee-info' ? 'current':'pending'">
                                <div class="wizard-label">
                                    <i class="wizard-icon la la-user icon-6x"></i>
                                    <h3 class="wizard-title">بيانات الموظف</h3>
                                </div>

                            </div>
                            <!--end::Wizard Step 1 Nav-->
                            <!--begin::Wizard Step 2 Nav-->
                            <div v-if="WizardType=='edit'" class="wizard-step cursor-pointer" data-wizard-type="step" @click="RunWeightChangeHistory()" :data-wizard-state="ActiveTap == 'Weight-info' ? 'current':'pending'">
                                <div class="wizard-label">
                                    <i class="wizard-icon la la-diamond icon-6x"></i>
                                    <h3 class="wizard-title">بيانات الوزنة</h3>
                                </div>

                            </div>
                            <!--end::Wizard Step 2 Nav-->

                            <!--begin::Wizard Step 3 Nav-->
                            <div v-if="WizardType=='edit'" class="wizard-step cursor-pointer" data-wizard-type="step" @click="RunSalesInfo()" :data-wizard-state="ActiveTap == 'sales-info' ? 'current':'pending'">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-coins icon-4x"></i>
                                    <h3 class="wizard-title">المبيعات</h3>
                                </div>

                            </div>
                            <!--end::Wizard Step 3 Nav-->

                        </div>
                    </div>
                    <!--end::Wizard Nav-->
                    <!--begin::Wizard Body-->
                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                        <div :class="ActiveTap == 'sales-info' ? 'col-xl-12 col-xxl-12 col-sm-12' : 'col-xl-12 col-xxl-7'">
                            <!--begin::Wizard Form-->
                            <div class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
                                <!--begin::Wizard Step 1-->
                                <div v-if=" ActiveTap == 'Employee-info' || ( Employee != undefined && Employee.id !=1 )" class="pb-5" data-wizard-type="step-content" :data-wizard-state="ActiveTap == 'Employee-info' ? 'current':'pending'">
                                    <employee-edit-create ref="EditCreateEmployee" @WizardTypeChanged="ChangeWizardType" @EmployeeDataChanged="ChangeEmployeeData" :Employee="Employee"></employee-edit-create>
                                </div>
                                <!--end::Wizard Step 1-->
                                <!--begin::Wizard Step 2-->
                                <div v-if="WizardType=='edit' && ActiveTap == 'Weight-info'" class="pb-5" data-wizard-type="step-content" :data-wizard-state="ActiveTap == 'Weight-info' ? 'current':'pending'">
                                    <employee-gold-history ref="EmployeeGoldHistory" @EmployeeDataChanged="ChangeEmployeeData" :Employee="Employee"></employee-gold-history>
                                </div>
                                <!--end::Wizard Step 2-->

                                <div>
                                    <!--start::Wizard Step 3-->
                                    <div v-if=" WizardType=='edit' && ActiveTap == 'sales-info' " class="pb-5" data-wizard-type="step-content" :data-wizard-state="ActiveTap == 'sales-info' ? 'current':'pending'">
                                        <employee-sales ref="SalesInfoComponent" :Employee="Employee"></employee-sales>
                                    </div>
                                    <!--end::Wizard Step 3-->
                                </div><div></div><div></div><div></div></div>
                            <!--end::Wizard Form-->
                        </div>
                    </div>
                    <!--end::Wizard Body-->
                </div>
                <!--end::Wizard-->
            </div>
            <!--end::Wizard-->
        </div>
    </div>

</template>

<script>
    export default {

        name: "EmployeeWizard",
        props:{
            'WizardType':'',
            'Employee':{},
        },
        created () {
            if(this.Employee != undefined&&this.Employee.id == 1){
                this.ActiveTap = 'Weight-info';
            }
        },
        data(){
            return{
                'ActiveTap':'Employee-info',
            }
        },
        methods : {
            ChangeWizardType(NewWizardType,SentEmployee){
                this.ChangeEmployeeData(SentEmployee);
                this.WizardType=NewWizardType;
            },
            ChangeEmployeeData(SentEmployee,render){
                this.Employee = {};
                for (const property in SentEmployee) {
                    this.Employee[property] = SentEmployee[property];
                }
                if(render){
                    this.$refs.EditCreateEmployee.CopyPropToDataEmployee();
                }
            },
            RunSalesInfo(){
                this.ActiveTap = 'sales-info';
            },
            RunWeightChangeHistory(){
                this.ActiveTap = 'Weight-info';
            }
        }
    }
</script>

<style scoped>

</style>
