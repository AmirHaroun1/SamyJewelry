<template>
    <div>
        <table class="table table-head-custom table-vertical-center table-head-bg table-borderless">
            <thead>
            <tr class="text-left">
                <th style="min-width: 40px">
                                        <span class="text-dark-75">

                                        </span>
                </th>
                <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                             البائع
                                        </span>
                </th>
                <th style="min-width: 100px"  >
                                        <span class="text-dark-75">
                                            قيمة الفاتورة
                                        </span>
                </th>
                <th style="min-width: 100px"  >
                                        <span class="text-dark-75">
                                            الوزن ١٨
                                        </span>
                </th>
                <th style="min-width: 100px"  >
                                        <span class="text-dark-75">
                                            الوزن ٢١
                                        </span>
                </th>
                <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            قيمة المباع
                                        </span>
                </th>
                <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            وزن الكسر ١٨
                                        </span>
                </th>
                <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            وزن الكسر ٢١
                                        </span>
                </th>
                <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            قيمة الكسر
                                        </span>
                </th>
                <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                        تاريخ الفاتورة
                                        </span>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="Invoice in Invoices" class="text-left">
                <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                            <a class="btn btn-success" :href="route('AdminInvoices.edit',Invoice.id)">
                                                                    الفاتورة
                                                <i class="flaticon2-file icon-md"></i>
                                            </a>
                                        </span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$parent.Employee.name}}</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.total_price)}} ج.م</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.total_weight_18}} جرام</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.total_weight_21}} جرام</span>
                </td>

                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.actual_price)}} ج.م</span>
                </td>

                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.from_buyer_total_weight_18}} جرام</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.from_buyer_total_weight_21}} جرام</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.actual_price - Invoice.total_price)}} ج.م</span>
                </td>
                <td>
                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatCreatedAt(Invoice.created_at)}}</span>
                </td>
                <td>
                <span class="text-dark-75 font-weight-bolder d-block font-size-sm">
                        <a class="btn btn-success btn-sm" @click="print(Invoice)">
                            <i class="flaticon2-print icon-md"></i>
                        </a>
                </span>
                </td>
            </tr>
            </tbody>

        </table>

    </div>
</template>

<script>
    export default {
        name: "InvoicesTable",
        props : {
            Invoices : []
        },
        data() {
            return {
                InvoiceToBePrinted : {},
            }
        },
        methods :{
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "")
            },
            formatCreatedAt(date) {
                return moment(date).format(" H:mm , DD - MM - YYYY");
            },
            print(Invoice){
                if(!Invoice.hasOwnProperty('products'))
                {
                    this.$parent.LoadingSpinner = true;
                    axios.get(route('api.AdminInvoices.loadProducts',Invoice.id))
                        .then(({data}) => {
                            this.$parent.LoadingSpinner = false;
                            this.$set(Invoice,'products',[]);
                            Invoice.products.push(...data.invoice.products);
                            console.log(data.invoice);
                        }).catch(error => {
                        this.$parent.LoadingSpinner = false;
                    })
                }
                this.$emit('PrintInvoice',Invoice);
            }
        }
    }
</script>

<style scoped>

</style>
