<template>
    <div class="card-body">

        <!--begin::Top-->
        <div class="d-flex">
            <!--begin::Pic-->
            <div class="flex-shrink-0 mr-7">
                <div class="symbol symbol-50 symbol-lg-120 symbol-light-danger">
                    <span class="font-size-h3 symbol-label font-weight-boldest" >{{Supplier.name}}</span>
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
                        <a :href="route('AdminSuppliers.edit',Supplier.id)" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">
                            {{Supplier.name}}
                        </a>
                        <!--end::Name-->
                        <!--begin::Contacts-->
                        <div class="d-flex flex-wrap my-2">
                            <a  :href="route('AdminSuppliers.edit',Supplier.id)" class=" text-hover-primary font-weight-bold mr-lg-8 mr-5 py-7 mb-lg-0 mb-2">
                                رقم الهاتف :
                                <b v-if="Supplier.phone != null">{{Supplier.phone}}</b>
                                <b v-if="Supplier.phone2 != null">-</b>
                                <b v-if="Supplier.phone2 != null">{{Supplier.phone2}}</b>
                            </a>

                        </div>
                        <!--end::Contacts-->
                    </div>
                    <!--begin::User-->

                </div>
                <!--end::Title-->

            </div>
            <!--end::Info-->
            <!--begin::Top-->

        </div>

    </div>
</template>

<script>
    export default {
        name: "SupplierCard",
        props:{
            Supplier : {},
        },
        data(){
            return {

            }
        }
    }
</script>

<style scoped>

</style>
