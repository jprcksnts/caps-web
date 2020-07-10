<template>
    <div>
        <qrcode-stream @decode="onQrDecode"></qrcode-stream>

        <div class="form-group mt-4 mb-0">
            <p class="mb-0">
                ID:
                <span id="scanned_product_id">N/A</span>
            </p>
            <p class="mb-0">
                UUID:
                <span id="scanned_product_uuid">
                    N/A
                </span>
            </p>
            <p class="mb-0">
                Code:
                <span id="scanned_product_code">
                    N/A
                </span>
            </p>
            <p class="mb-0">
                Name:
                <span id="scanned_product_name">
                    N/A
                </span>
            </p>
        </div>
    </div>
</template>

<script>
    import {QrcodeStream} from "vue-qrcode-reader";
    import Vue from 'vue';
    import axios from 'axios'
    import VueAxios from 'vue-axios'

    Vue.use(VueAxios, axios);
    export default {
        components: {
            QrcodeStream,
        },
        methods: {
            onQrDecode(decodedString) {
                Vue.axios.get('http://caps-web.test/api/product/uuid/' + decodedString).then((response) => {
                    var data = response.data['data'];
                    console.log(response.status);
                    if (response.status >= 200 && response.status < 300) {
                        $('#scanned_product_id').text(data['product']['id']);
                        $('#scanned_product_uuid').text(data['product']['uuid']);
                        $('#scanned_product_code').text(data['product']['code']);
                        $('#scanned_product_name').text(data['product']['name']);


                        $('#product_id').val(data['product']['id']);
                    } else {
                        $('#scanned_product_uuid').text('N/A');
                    }
                });
            }
        }
    }
</script>
