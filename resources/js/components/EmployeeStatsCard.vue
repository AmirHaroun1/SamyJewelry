<template>
    <div class="card-body">
        <!--begin::Top-->
        <div class="d-flex">
            <!--begin::Pic-->
            <div class="flex-shrink-0 mr-7">
                <div class="symbol symbol-50 symbol-lg-120 symbol-light-danger">
                    <span class="font-size-h3 symbol-label font-weight-boldest" >{{employee.name}}</span>
                </div>
            </div>
            <!--end::Pic-->
            <!--begin: Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
                    <!--begin::User-->
                    <div class="mr-3">
                        <!--begin::Name-->
                        <a :href="route('AdminEmployees.edit',employee.id)" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">
                            {{employee.name}}
                            <i class="flaticon2-correct text-success icon-md ml-2" v-if="employee.id == 1"></i></a>
                        <!--end::Name-->
                        <!--begin::Contacts-->
                        <div class="d-flex flex-wrap my-2">
                            <a  :href="route('AdminEmployees.edit',employee.id)" class=" text-hover-primary font-weight-bold mr-lg-8 mr-5 py-7 mb-lg-0 mb-2" v-if="employee.name != 'البترينة'">
                                الرقم القومي :
                                {{employee.national_id}}
                            </a>

                        </div>
                        <!--end::Contacts-->
                    </div>
                    <!--begin::User-->

                </div>
                <!--end::Title-->

            </div>
            <!--end::Info-->
        </div>
        <!--end::Top-->
        <!--begin::Separator-->
        <div class="separator separator-solid my-7"></div>
        <!--end::Separator-->
        <!--begin::Bottom-->
        <div class="d-flex align-items-center justify-content-center flex-wrap">
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-2 my-1" v-if="employee.id != 1">
												<span class="mr-3">
													<i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
												</span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">مجمل مبيعات الشهر</span>
                    <span class="font-weight-bolder font-size-h5">
                                                        {{formatPrice(employee.CurrentMonthSales)}}
													<span class="text-dark-50 font-weight-bold">
                                                        ج.م
                                                    </span>
                                    </span>
                </div>
            </div>
            <!--end: Item-->

            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-2 my-1" v-if="employee.id !=1">
												<span class="mr-3">
													<i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
												</span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm"> وزن مبيعات الشهر ١٨</span>
                    <span class="font-weight-bolder font-size-h5">
                        <b v-if="employee.CurrentMonthTotalWeight_18 != null">{{employee.CurrentMonthTotalWeight_18}}</b>
                        <b v-else>0</b>
													<span class="text-dark-50 font-weight-bold">
                                                        جرام
                                                    </span>
                                    </span>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-2 my-1" v-if="employee.id !=1">
												<span class="mr-3">
													<i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
												</span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm"> وزن مبيعات الشهر ٢١</span>
                    <span class="font-weight-bolder font-size-h5">
                        <b v-if="employee.CurrentMonthTotalWeight_21 != null">{{employee.CurrentMonthTotalWeight_21}}</b>
                        <b v-else>0</b>
													<span class="text-dark-50 font-weight-bold">
                                                        جرام
                                                    </span>
                                    </span>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg mr-5 my-1">
                <span class="mr-3" >
                    <i class="la la-diamond icon-3x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column flex-lg-fill">
                    <span class="text-dark-75 font-weight-bolder font-size-sm">الوزنة عيار ١٨</span>
                    <a href="#" class="text-primary font-weight-bolder">{{employee.current_weight_18}} جرام</a>
                </div>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <button @click="Added_weight_18 = 0.0" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" >
                            <i class="flaticon-plus"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right " style="">
                            <!--begin::Navigation-->
                            <div class="container">
                                <label> اضافة وزنة عيار ١٨، مثال ( 258.30 )</label>
                                <input v-model="Added_weight_18" type="number" class="form-control" @keypress.enter="Added_weight_18 == '' || Added_weight_18 == 0 ? '':UpdateWeight(employee,18)"  >
                                <div class="card-footer text-center justify-content-center">
                                    <button @click="Added_weight_18 == '' || Added_weight_18 == 0 ? '':UpdateWeight(employee,18)" type="reset" class="btn btn-primary ">اضافة وزنة</button>
                                </div>
                            </div>
                            <!--end::Navigation-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg mr-5 my-1">
												<span class="mr-3" >
													<i class="la la-diamond icon-3x text-muted font-weight-bold"></i>
												</span>
                <div class="d-flex flex-column">
                    <span class="text-dark-75 font-weight-bolder font-size-sm">الوزنة عيار ٢١</span>
                    <a href="#" class="text-primary font-weight-bolder">{{employee.current_weight_21}} جرام</a>
                </div>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <button @click="Added_weight_21 = 0.0" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" >
                            <i class="flaticon-plus"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right " style="">
                            <!--begin::Navigation-->
                            <div class="container">
                                <label> اضافة وزنة عيار ٢١، مثال ( 258.30 )</label>
                                <input v-model="Added_weight_21" type="number" class="form-control" @keypress.enter="Added_weight_21 == '' || Added_weight_21 == 0 ? '':UpdateWeight(employee,21)"  >
                                <div class="card-footer text-center justify-content-center">
                                    <button @click="Added_weight_21 == '' || Added_weight_21 == 0 ? '':UpdateWeight(employee,21)" type="reset" class="btn btn-primary ">اضافة وزنة</button>
                                </div>
                            </div>
                            <!--end::Navigation-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Item-->
        </div>
        <!--end::Bottom-->
    </div>
</template>

<script>
    export default {
        name: "EmployeeStatsCard",
        props:{
            employee:{},
        },
        data() {
            return {
                Added_weight_18:0.0,
                Added_weight_21:0.0,
            }
        },
        methods : {
            UpdateWeight(employee,WeightType){

                let formData = new FormData();
                formData.append('_method',"PATCH");
                formData.append('weight_change',"add_weight");
                if(WeightType == 18){
                    formData.append('current_weight_18',this.Added_weight_18);
                }else{
                    formData.append('current_weight_21',this.Added_weight_21);
                }
                axios.post(route('AdminEmployees.update',employee.id),formData)
                    .then(res => {
                        console.log(res);
                        if(WeightType == 18){
                            employee.current_weight_18 = parseFloat(employee.current_weight_18) + parseFloat( this.Added_weight_18 );
                        }else{
                            employee.current_weight_21 = parseFloat(employee.current_weight_21) + parseFloat( this.Added_weight_21 );
                        }
                        this.$swal({
                            icon:'success',
                            title:'تم تعديل البيانات بنجاح',
                            showConfirmButton: false,
                            timer: 800
                        })
                    }).catch(error => {
                    console.log(error);
                    this.$swal({
                        title:'حدث خطأ يرجي اعادة المحاولة',
                        icon:'error',
                    })
                })
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "")
            },
        }
    }
</script>

<style scoped>

</style>
