import BaseApi from "@api/base.api";
import Http from "@services/http";

export default class LogApi extends BaseApi {

    static get entity() {
        return 'settings/logs'
    }
    static async getModulesActions() {
        return await Http.get(`${this.entity}/modules-actions`)
    }
}
