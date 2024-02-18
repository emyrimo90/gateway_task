import BaseApi from "@api/base.api";

export default class GeneralSettingsApi extends BaseApi{

    static get entity()
    {
        return 'settings/general'
    }
}
