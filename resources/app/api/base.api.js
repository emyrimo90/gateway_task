import Http from "@services/http"

export default class BaseApi {

    static get entity() {
        throw new Error('entity getter not defined')
    }

    static async list(params = {}) {
        return await Http.get(`${this.entity}`, params)
    }

    static async get(model, params = null, modelType = 'object') {
        let id = (modelType === 'object') ? model.id : model;
        return await Http.get(`${this.entity}/${id}`, params)
    }

    static async store(model) {
        return await Http.post(`${this.entity}`, model)
    }

    static async update(model) {
        return await Http.put(`${this.entity}/${model.id}`, model)
    }

    static async delete(model) {
        return await Http.delete(`${this.entity}/${model.id}`)
    }

    static async changeStatus(model) {
        return await Http.post(`${this.entity}/change-status/${model.id}`)
    }
    static async exportData(type='excel', params) {
        return await Http.post(`${this.entity}/${type}/export-data`, params);
    }
    static async print(params) {
        return await Http.get(`${this.entity}/print`, params);
    }
    static async excel(params) {
        return await Http.get(`${this.entity}/excel`, params);
    }

    static async pdf(params) {
        return await Http.get(`${this.entity}/pdf`, params);
    }


}
