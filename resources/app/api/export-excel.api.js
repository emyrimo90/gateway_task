import Http from "@services/http";

export default class ExportExcelApi {

    static get entity() {
        return 'export-excel'
    }
    static get reportEntity() {
        return 'reports'
    }
    static async logsReport(params) {
        return await Http.get(this.entity + '/'+ this.reportEntity +'/logs', params)
    }
}
