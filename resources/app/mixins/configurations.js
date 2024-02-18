import i18n from "@/lang";
const {t} = i18n.global;

export default {
    data(){
        return {
            publicPath: import.meta.env.VITE_VUE_APP_ROOT + '/',
            publicUrl: import.meta.env.VITE_VUE_APP_ROOT,
            fileImageDefault: import.meta.env.VITE_SERVER_URL+ '/assets/images/files/file.png'
        }
    },
    computed: {
        sharedLayoutDirection(){
           return  this.$i18n.locale == 'en'? 'ltr':'rtl';
        }
    },
    methods:{
        getGenderForSelect(){
            return [
                {
                    id:0,
                    name:t('male')
                },
                {
                    id:1,
                    name:t('female')
                }
            ];
        },
        getPublicPath(){
            return this.publicPath;
        },
        getDefaultImage(){
            return this.publicPath+'/assets/images/avatar.png';
        },
        downloadFile(data){
            const docUrl = document.createElement('a');
            docUrl.href =  data.link;
            docUrl.setAttribute('download', 'report.pdf');
            document.body.appendChild(docUrl);
            docUrl.click();
        },
        printFile(html){
            var divContents = html;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
            return;
        },
        avatarOnError(){
            return this.publicPath+ '/assets/images/client.png';
        }
    }
}
