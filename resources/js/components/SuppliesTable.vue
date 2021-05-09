<template>
    <div class="  mt-10 pt-10 pb-10  card card-custom gutter-b">
        <!--begin::head-->
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">التورديات</span>
            </h3>
            <div class="card-toolbar">
                <a :href="route('AdminSupplies.create',Supplier.id)" class="btn btn-success font-weight-bolder font-size-sm">أمر توريد جديد</a>
            </div>
        </div>
        <!--end::head-->
        <!--begin::Body-->
        <div class="card-body pt-0 pb-3">
            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless">
                <thead>
                <tr class="text-left">
                    <th>
                        <span class="text-dark-75">

                        </span>
                    </th>
                    <th>
                        <span class="text-dark-75">
                            التاريخ
                        </span>
                    </th>
                    <th>
                        <span class="text-dark-75">
                            الأسم
                        </span>
                    </th>
                    <th >
                        <span class="text-dark-75">
                            اضافة ذهب عيار ١٨
                        </span>
                    </th>
                    <th >
                        <span class="text-dark-75">
                            اضافة ذهب عيار ٢١
                        </span>
                    </th>
                    <th >
                        <span class="text-dark-75">
                            ثمن الذهب العيار ١٨
                        </span>
                    </th>
                    <th >
                        <span class="text-dark-75">
                            ثمن الذهب العيار ٢١
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="Supplier.hasOwnProperty('supplies')" v-for="supply in Supplier.supplies" class="text-left my-7">
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                             <a class="btn btn-success" :href="route('AdminSupplies.edit',supply.id)">
                                                                    امر التوريد
                                                <i class="flaticon2-file icon-md"></i>
                             </a>
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                {{formatDate(supply.created_at)}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                {{Supplier.name}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                {{supply.weight_amount_18}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                {{supply.weight_amount_21}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                {{formatPrice(supply.money_for_18)}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                {{formatPrice(supply.money_for_21)}}
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-center align-items-center text-center  flex-wrap">
                <div class="d-flex flex-wrap mr-3">
                    <a @click="FetchSupplierSupplies(FetchPaginationData.current_page + 1)" v-if="FetchPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                        <i class="ki ki-bold-arrow-next icon-xs"></i>
                    </a>


                    <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                        صفحة

                        {{FetchPaginationData.current_page}}
                        من
                        {{FetchPaginationData.last_page}}
                    </a>

                    <a @click="FetchSupplierSupplies(FetchPaginationData.current_page-1)" v-if="FetchPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Body-->
        <loading-spinner v-if="LoadingSpinner"></loading-spinner>

    </div>
</template>

<script>
    export default {
        name: "suppliesTable",
        props:{
            Supplier:{},
        },
        created(){
            this.FetchSupplierSupplies();
        },
        data(){
            return {
                FetchPaginationData:{},
                LoadingSpinner :false,
            }
        },
        methods:{
            FetchSupplierSupplies(page = 1){
                this.LoadingSpinner = true;
                    axios.get(route('api.AdminSupplies.index',{'page' : page,'supplier_id':this.Supplier.id}))
                        .then(res => {
                            this.LoadingSpinner = false;
                            if(res.data.supplies.data.length){
                                this.$set(this.Supplier,'supplies',[]);
                                this.Supplier.supplies.push(...res.data.supplies.data);
                            }
                            this.FetchPaginationData.current_page = res.data.supplies.current_page;
                            this.FetchPaginationData.last_page = res.data.supplies.last_page;
                            this.FetchPaginationData.next_page_url = res.data.supplies.next_page_url;
                            this.FetchPaginationData.prev_page_url = res.data.supplies.prev_page_url;
                        }).catch(error => {
                            this.LoadingSpinner = false;
                        })
            },
            formatDate(value){
              return moment(value).format('YYYY-MM-DD ,H:mm')
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
