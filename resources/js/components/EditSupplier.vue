<template>
    <div>
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
                                <div class="wizard-step cursor-pointer" data-wizard-type="step" @click="ActiveTap = 'supplier-info'" :data-wizard-state="ActiveTap == 'supplier-info' ? 'current':'pending'">
                                    <div class="wizard-label">
                                        <i class="wizard-icon la la-user icon-6x"></i>
                                        <h3 class="wizard-title">بيانات المورد</h3>
                                    </div>

                                </div>
                                <!--end::Wizard Step 1 Nav-->
                                <!--begin::Wizard Step 2 Nav-->
                                <div class="wizard-step cursor-pointer" data-wizard-type="step" @click="ActiveTap = 'supplies-info'" :data-wizard-state="ActiveTap == 'supplies-info' ? 'current':'pending'">
                                    <div class="wizard-label">
                                        <i class="la la-truck-loading icon-6x"></i>
                                        <h3 class="wizard-title">التوريدات</h3>
                                    </div>

                                </div>
                                <!--end::Wizard Step 2 Nav-->
                            </div>
                        </div>
                        <!--end::Wizard Nav-->
                        <!--begin::Wizard Body-->
                        <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                            <div :class="ActiveTap == 'supplies-info' ? 'col-xl-12' :  'col-xxl-7' ">
                                <!--begin::Wizard Form-->
                                <div class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
                                    <!--begin::Wizard Step 1-->
                                    <div v-if=" ActiveTap == 'supplier-info'" class="pb-5" data-wizard-type="step-content" :data-wizard-state="ActiveTap == 'Employee-info' ? 'current':'pending'">
                                        <create-edit-supplier :sent-supplier="Supplier" :create-mood="false"></create-edit-supplier>
                                    </div>
                                    <!--end::Wizard Step 1-->
                                    <!--begin::Wizard Step 2-->
                                    <div v-else-if="ActiveTap == 'supplies-info'" class="pb-5" data-wizard-type="step-content" :data-wizard-state="ActiveTap == 'Weight-info' ? 'current':'pending'">
                                        <supplies-table :supplier="Supplier"></supplies-table>
                                    </div>
                                    <!--end::Wizard Step 2-->

                                    <div>


                                    </div><div></div><div></div><div></div></div>
                                <!--end::Wizard Form-->
                            </div>
                        </div>
                        <!--end::Wizard Body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditSupplier",
        data(){
            return {
                ActiveTap: 'supplier-info',
            }
        },
        props :{
            Supplier : {},
        },
        methods : {

        },
    }
</script>

<style scoped>

</style>
