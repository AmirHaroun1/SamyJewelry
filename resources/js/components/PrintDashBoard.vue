<template>
    <div id="printable">
        <table style="width:100%">
            <tr>
                <th> عدد الفواتير : </th>

                <td>
                    <b v-if="InvoicesStats.TotalInvoices != null">{{InvoicesStats.TotalInvoices}}</b>
                    <b v-else>0</b>
                </td>
            </tr>
            <tr>
                <th>اجمالي قيمة الفواتير : </th>

                <td> <b>{{InvoicesStats.TotalSoldPrice}}
                    ج.م
                </b>

                </td>
            </tr>
            <tr>
                <th>اجمالي قيمة المباع :</th>
                <td>
                    <b >{{InvoicesStats.TotalActualPrice}}
                        ج.م
                    </b>

                </td>
            </tr>
            <tr>
                <th>اجمالي قيمة الكسر :</th>
                <td>
                    <b>{{ConvertToPositive(InvoicesStats.TotalSoldPrice - InvoicesStats.TotalActualPrice)}}
                        ج.م
                    </b>

                </td>
            </tr>
            <tr>
                <th> اجمالي المدفوع فيزا :</th>
                <td>
                    <b >{{InvoicesStats.TotalPaidInVisa}}
                        ج.م
                    </b>

                </td>
            </tr>
            <tr>
                <th> اجمالي المدفوع كاش :</th>
                <td>
                    <b >{{InvoicesStats.TotalPaidInCache}}
                        ج.م

                    </b>
                </td>
            </tr>
            <tr>
                <th>مباع عيار ١٨ :</th>
                <td>
                    <b>
                    {{InvoicesStats.TotalSoldWeight_18}}
                    جرام
                    </b>
                </td>
            </tr>
            <tr>
                <th>مباع عيار ٢١ :</th>
                <td>
                    <b>
                    {{InvoicesStats.TotalSoldWeight_21}}
                    جرام
                    </b>
                </td>
            </tr>
            <tr>
                <th>كسر عيار ١٨ :</th>
                <td>
                    <b>
                    {{InvoicesStats.FromBuyerTotalWeight_18}}
                    جرام
                    </b>
                </td>
            </tr>
            <tr>
                <th>كسر عيار ٢١ :</th>
                <td>
                    <b>
                    {{InvoicesStats.FromBuyerTotalWeight_21}}
                    جرام
                    </b>
                </td>
            </tr>
            <tr>
                <th>المدفوع نقدى :</th>
                <td>
                    <b>
                    {{PaymentsStats.paid_price}}
                    ج.م
                    </b>
                </td>
            </tr>
            <tr>
                <th>  مدفوع عيار ١٨ :</th>
                <td>
                    <b>
                    {{PaymentsStats.paid_weight_18}}
                    جرام
                    </b>
                </td>

            </tr>
            <tr>
                <th>  مدفوع عيار ٢١ :</th>
                <td>
                    <b>
                    {{PaymentsStats.paid_weight_21}}
                    جرام
                    </b>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { Printd } from 'printd'

    export default {
        name: "PrintDashBoard",
        props : {
            InvoicesStats:{},
            PaymentsStats:{},
        },
        created(){
            this.printSection();
        },
        methods : {
            printSection(){
                const d = new Printd();
                const styles = [
                    'body{height:5px;direction:rtl}',
                    '.text-center{text-align: center;}',
                    '.mt-5{margin-top: 5px;}',
                    '.mt-3{margin-top: 3px;}',
                    '.mt-15{margin-top: 15px;}',
                    '.mr-7{padding-right: 7px;}',
                    '.py-5{padding-top: 5px;padding-bottom:5px}',
                    '.rtl{direction: rtl;}',
                    '.text-right{float: right;}',
                    '.invoice_title {color: black;}',
                    'table{font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}',
                    'td, th{border: 1px solid #dddddd;text-align:right;padding: 8px;}',
                    '.invoice_total{width:100%;background-color:  #e5e5e5}',
                    '.paddingAdjust{margin-top:-19px}'
                ]
                setTimeout(()=>{
                    d.print( document.getElementById('printable'), styles );

                    this.$parent.PrintingMood = false;
                },1000);
            },
            ConvertToPositive(value){
                if(value < 0){
                    return -1 * value;
                }else {
                    return value;
                }
            },
        }
    }
</script>

<style scoped>

</style>
