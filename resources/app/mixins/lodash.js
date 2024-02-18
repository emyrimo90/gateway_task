import _ from 'lodash';
export default {
    methods : {
        _get(ob, path, defaultVal = null){
            return _.get(ob, path, defaultVal);
        },
        _size(arrays){
            return _.size(arrays);
        },
    }
}
