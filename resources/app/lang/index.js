import {createI18n} from 'vue-i18n'

// import i18n resources
import en from '../../../lang/en.json'
import ar from '../../../lang/ar.json'
import Storage from "@services/storage";

const i18n = createI18n({
    locale: Storage.get('lang'), // set locale
    fallbackLocale: 'en', // set fallback locale
    pluralizationRules: {
        ar: pluralizationRulesAR
    },
    messages: {
        en,
        ar,
    },
})

function pluralizationRulesAR(choice, choicesLength, orgRule) {
    switch (true) {
        case ! choice:
            return 0;
        case (choice == 1 || choice > 10):
            return 1;
        case (choice == 2):
            return 2;
        case (choice >= 3 && choice <= 10):
            return 3;
    }
}

export default i18n
