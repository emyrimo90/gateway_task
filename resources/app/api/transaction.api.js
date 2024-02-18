import BaseApi from "./base.api";
import Http from "@services/http";

export default class GatewaySettingApi extends BaseApi {

    static get entity() {
        return 'transactions';
    }

    static async processTransaction(params={}) {
        return await Http.post(`${this.entity}/process-transaction`, params)
    }
}
