import { mapGetters } from 'vuex'
export default {
    created() {

    },
    data(){
        return {
            numbers: {
                0: "০",
                1: "১",
                2: "২",
                3: "৩",
                4: "৪",
                5: "৫",
                6: "৬",
                7: "৭",
                8: "৮",
                9: "৯",
              },
              months: ["January","February","March","April","May","June","July","August","September","October","November","December"],
              school_id: this.$localStorage.getItem('getschoolid'),
              exams:{},
              subjects:{},
              religions:{},
              groups:{},
              schoolinfo:{},


        }
    },

    methods: {
        async callApi(method, url, dataObj ){
            try {
              return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }
        },


        ex_fee_name(name){
            if(name=='Half_yearly_examination'){
                return 'অর্ধ বার্ষিক পরীক্ষার ফি';
            }else if(name=='Half_yearly_evaluation'){
                return 'অর্ধ বার্ষিক মূল্যায়ন ফি';
            }else if(name=='Annual Examination'){
                return 'বার্ষিক পরীক্ষার ফি';
            }else if(name=='Annual_Examination'){
                return 'বার্ষিক পরীক্ষার ফি';
            }else if(name=='Annual_assessment'){
                return 'বার্ষিক মূল্যায়ন ফি';
            }else if(name=='Model_test_exam'){
                return 'মডেল টেস্ট পরীক্ষার ফি';
            }else if(name=='Pre_selection_examination'){
                return 'প্রাক-নির্বাচনী পরীক্ষার ফি';
            }else if(name=='Selective_Exam'){
                return 'নির্বাচনী পরীক্ষার ফি';
            }else if(name=='Continuous_assessment'){
                return 'ধারাবাহিক মূল্যায়ন ফি';
            }else if(name=='Summative_Assessment'){
                return 'সামষ্টিক মূল্যায়ন ফি';
            }else if(name=='Admission_fee'){
                return 'আবেদন ফি';
            }

        },



        ex_name(name){
            if(name=='Half_yearly_examination'){
                return 'অর্ধ বার্ষিক পরীক্ষার ফি';
            }else if(name=='Half_yearly_evaluation'){
                return 'অর্ধ বার্ষিক মূল্যায়ন ফি';
            }else if(name=='Annual_Examination'){
                return 'বার্ষিক পরীক্ষার ফি';
            }else if(name=='Annual_assessment'){
                return 'বার্ষিক মূল্যায়ন ফি';
            }else if(name=='Model_test_exam'){
                return 'মডেল টেস্ট পরীক্ষার ফি';
            }else if(name=='Pre_selection_examination'){
                return 'প্রাক-নির্বাচনী পরীক্ষার ফি';
            }else if(name=='Selective_Exam'){
                return 'নির্বাচনী পরীক্ষার ফি';
            }else if(name=='Continuous_assessment'){
                return 'ধারাবাহিক মূল্যায়ন ফি';
            }else if(name=='Summative_Assessment'){
                return 'সামষ্টিক মূল্যায়ন ফি';
            }

        },


         class_en_to_bn(name){

            if(name=='Play'){
                return 'শিশু শ্রেণি';
            }else if(name=='Nursery'){
                return 'নার্সারি';
            }else if(name=='One'){
                return 'প্রথম শ্রেণি';
            }else if(name=='Two'){
                return 'দ্বিতীয় শ্রেণি';
            }else if(name=='Three'){
                return 'তৃতীয় শ্রেণী';
            }else if(name=='Four'){
                return 'চতুর্থ শ্রেণী';
            }else if(name=='Five'){
                return 'পঞ্চম শ্রেণী';
            }else if(name=='Six'){
                return 'ষষ্ঠ শ্রেণী';
            }else if(name=='Seven'){
                return 'সপ্তম শ্রেণী';
            }else if(name=='Eight'){
                return 'অষ্টম শ্রেণী';
            }else if(name=='Nine'){
                return 'নবম শ্রেণী';
            }else if(name=='Ten'){
                return 'দশম শ্রেণী';
            }else{

                return 'কোনো শ্রেণি নেই';
            }

            },








            feeStatusText(status){
                if(status==1){
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }else if(status==0){
                    return '<span class="badge badge-pill badge-danger">Deactive</span>';
                }
            },


        async schoolDetial(type=''){
            var res = await this.callApi('get',`/api/school/settings?school_id=${this.school_id}&front=${type}`,[]);
            this.schoolinfo = res.data
        },
        paymentamount(type, classname) {
            var needAmount;
            if (type == 'monthly_fee') {
                if (classname == 'Eight') {
                    needAmount = 500;
                } else if (classname == 'Nine') {
                    needAmount = 500;
                } else if (classname == 'Ten') {
                    needAmount = 500;
                } else {
                    needAmount = 400;
                }
            } else if (type == 'session_fee') {
                needAmount = 500;
            } else if (type == 'Exam_fee') {
                needAmount = 200;
            } else {
                needAmount = 0;
            }
            return needAmount;
        },
        feesconvert(text) {
            var result;
            if (text == 'monthly_fee') {
                result = 'মাসিক বেতন';
            } else if (text == 'মাসিক বেতন') {
                result = 'monthly_fee';
            } else if (text == 'session_fee') {
                result = 'সেশন ফি';
            } else if (text == 'সেশন ফি') {
                result = 'session_fee';
            } else if (text == 'Exam_fee') {
                result = 'পরিক্ষার ফি';
            } else if (text == 'পরিক্ষার ফি') {
                result = 'Exam_fee';
            } else if (text == 'Other') {
                result = 'অন্যান্য';
            } else if (text == 'অন্যান্য') {
                result = 'Other';
            } else if (text == 'Admission_fee') {
                result = 'আবেদন ফি';
            } else if (text == 'আবেদন ফি') {
                result = 'Admission_fee';
            }
            return result;
        },

        async monthslist(){
            var res = await this.callApi('get',`/api/years/list?type=month`,[]);
            this.months = res.data;

        },
            async yearslist(){
            var res = await this.callApi('get',`/api/years/list?type=year`,[]);
            this.years = res.data;
        },
            async all_list(type = '', classname = '', group = ''){
            var res = await this.callApi('get',`/api/years/list?type=${type}&class=${classname}&group=${group}`,[]);
            if(type=='groups'){
                this.groups = res.data;
            }else if(type=='exams'){
                this.exams = res.data;
            }else if(type=='religions'){
                this.religions = res.data;
            }else if(type=='subjects'){
                this.subjects = res.data;
            }

        },
        subjectconverten(str) {
            if (str == 'বাংলা') {
                str = "Bangla";
            } else if (str == 'বাংলা ১ম') {
                str = "Bangla_1st";
            }
            else if (str == 'বাংলা ২য়') {
                str = "Bangla_2nd";
            }
            else if (str == 'ইংরেজি') {
                str = "English";
            }
            else if (str == 'ইংরেজি ১ম') {
                str = "English_1st";
            }
            else if (str == 'ইংরেজি ২য়') {
                str = "English_2nd";
            }
            else if (str == 'গণিত') {
                str = "Math";
            } else if (str == 'জীব বিজ্ঞান') {
                str = "Biology";
            } else if (str == 'বিজ্ঞান') {
                str = "Science";
            } else if (str == 'পদার্থবিজ্ঞান') {
                str = "physics";
            } else if (str == 'রসায়ন') {
                str = "Chemistry";
            } else if (str == 'ভূগোল ও পরিবেশ') {
                str = "vugol";
            } else if (str == 'অর্থনীতি') {
                str = "orthoniti";
            } else if (str == 'বাংলাদেশ ও বিশ্ব সভ্যতার ইতিহাস') {
                str = "itihas";
            } else if (str == 'ইতিহাস ও সামাজিক বিজ্ঞান') {
                str = "B_and_B";
            } else if (str == 'ধর্ম ও নৈতিক শিক্ষা') {
                str = "Religion";
            } else if (str == 'ইসলাম-ধর্ম') {
                str = "ReligionIslam";
            } else if (str == 'হিন্দু-ধর্ম') {
                str = "ReligionHindu";
            } else if (str == 'জীবন ও জীবিকা') {
                str = "Agriculture";
            } else if (str == 'উচ্চতর গণিত') {
                str = "Higher_Mathematics";
            } else if (str == 'ডিজিটাল প্রযুক্তি') {
                str = "ICT";
            } else if (str == 'স্বাস্থ্য ও সুরক্ষা') {
                str = "Physical_Education_and_Health";
            } else if (str == 'শিল্প ও সংস্কৃতি') {
                str = "Arts_and_Crafts";
            } else if (str == 'কর্ম ও জীবনমুখী শিক্ষা') {
                str = "Work_and_life_oriented_education";
            } else if (str == 'ক্যারিয়ার শিক্ষা') {
                str = "Career_Education";
            }


            else if (str == 'বিজ্ঞান অনুসন্ধানী পাঠ') {
                str = "Science_Inquiry_Lessons";
            } else if (str == 'বিজ্ঞান অনুশীলন বই') {
                str = "Science_practice_book";
            } else if (str == 'ইতিহাস ও সামাজিক বিজ্ঞান অনুসন্ধানী পাঠ') {
                str = "History_and_Social_Science_Inquiry_Lessons";
            } else if (str == 'ইতিহাস ও সামাজিক বিজ্ঞান অনুশীলন বই') {
                str = "History_and_Social_Science_Practice_Books";
            } else if (str == 'ডিজিটাল প্রযুক্তি') {
                str = "Digital_technology";
            } else if (str == 'স্বাস্থ্য সুরক্ষা') {
                str = "Health_protection";
            } else if (str == 'জীবন ও জীবিকা') {
                str = "Life_and_livelihood";
            } else if (str == 'শিল্প ও সংস্কৃতি') {
                str = "Art_and_Culture";
            }




            return str;
        },
        exam_comvert(str) {
            let banglaNumber =
            {

                "Admition Result":"Admition_Result",
                "Half Yearly":"Half_Yearly",
                 "Pre-Test":"Pre_Test",
                 "Annual Examination":"Annual_Examination",
                 "Model Test":"Model_Test",
                 "Test":"Test",

                // "Weakly Examination": "Weakly_Examination",
                // "ADMITION TEST RESULT": "ADMITION_TEST_RESULT",
                // "First Terminals Examination": "First_Terminals_Examination",
                // "Second Terminals Examination": "Second_Terminals_Examination",
                // "Annual Examination": "Annual_Examination",
                // "Test Examination": "Test_Examination",
            }
            for (var x in banglaNumber) {
                str = str.replace(new RegExp(x, 'g'), banglaNumber[x]);
            }
            return str;
        },
        subjectconvertbn(str) {

            if (str == 'Bangla') {
                str = "বাংলা";
            } else if (str == 'Bangla_1st') {
                str = "বাংলা ১ম";
            }
            else if (str == 'Bangla_2nd') {
                str = "বাংলা ২য়";
            }
            else if (str == 'English') {
                str = "ইংরেজি";
            }
            else if (str == 'English_1st') {
                str = "ইংরেজি ১ম";
            }
            else if (str == 'English_2nd') {
                str = "ইংরেজি ২য়";
            }
            else if (str == 'Math') {
                str = "গণিত";
            } else if (str == 'Science') {
                str = "বিজ্ঞান";
            } else if (str == 'physics') {
                str = "পদার্থবিজ্ঞান";
            } else if (str == 'Chemistry') {
                str = "রসায়ন";
            } else if (str == 'Biology') {
                str = "জীব বিজ্ঞান";
            } else if (str == 'vugol') {
                str = "ভূগোল ও পরিবেশ";
            } else if (str == 'orthoniti') {
                str = "অর্থনীতি";
            } else if (str == 'itihas') {
                str = "বাংলাদেশ ও বিশ্ব সভ্যতার ইতিহাস";
            } else if (str == 'B_and_B') {
                str = "ইতিহাস ও সামাজিক বিজ্ঞান";
            } else if (str == 'Religion') {
                str = "ধর্ম ও নৈতিক শিক্ষা";
            } else if (str == 'ReligionIslam') {
                str = "ইসলাম-ধর্ম";
            } else if (str == 'ReligionHindu') {
                str = "হিন্দু-ধর্ম";
            } else if (str == 'Higher_Mathematics') {
                str = "উচ্চতর গণিত";
            } else if (str == 'Agriculture') {
                str = "জীবন ও জীবিকা";
            } else if (str == 'ICT') {
                str = "ডিজিটাল প্রযুক্তি";
            } else if (str == 'Physical_Education_and_Health') {
                str = "স্বাস্থ্য ও সুরক্ষা";
            } else if (str == 'Arts_and_Crafts') {
                str = "শিল্প ও সংস্কৃতি";
            } else if (str == 'Work_and_life_oriented_education') {
                str = "কর্ম ও জীবনমুখী শিক্ষা";
            } else if (str == 'Career_Education') {
                str = "ক্যারিয়ার শিক্ষা";
            }

            else if (str == 'Science_Inquiry_Lessons') {
                str = "বিজ্ঞান অনুসন্ধানী পাঠ";
            } else if (str == 'Science_practice_book') {
                str = "বিজ্ঞান অনুশীলন বই";
            } else if (str == 'History_and_Social_Science_Inquiry_Lessons') {
                str = "ইতিহাস ও সামাজিক বিজ্ঞান অনুসন্ধানী পাঠ";
            } else if (str == 'History_and_Social_Science_Practice_Books') {
                str = "ইতিহাস ও সামাজিক বিজ্ঞান অনুশীলন বই";
            } else if (str == 'Digital_technology') {
                str = "ডিজিটাল প্রযুক্তি";
            } else if (str == 'Health_protection') {
                str = "স্বাস্থ্য সুরক্ষা";
            } else if (str == 'Life_and_livelihood') {
                str = "জীবন ও জীবিকা";
            } else if (str == 'Art_and_Culture') {
                str = "শিল্প ও সংস্কৃতি";
            }


            return str;
        },
        examcomvert(str) {
            let banglaNumber =
            {
                "Weakly_Examination": "Weakly Examination",
                "ADMITION_TEST_RESULT": "ADMITION TEST RESULT",
                "First_Terminals_Examination": "First Terminals Examination",
                "Second_Terminals_Examination": "Second Terminals Examination",
                "Annual_Examination": "Annual Examination",
                "Test_Examination": "Test Examination"
            }
            for (var x in banglaNumber) {
                str = str.replace(new RegExp(x, 'g'), banglaNumber[x]);
            }
            return str;
        },
        dateformatGlobal(date=''){
           return  User.dateformat(date);
        },

         getMonthFromString(mon){
            return new Date(Date.parse(mon +" 10, 2022")).getMonth()+1
         },
        // int_en_to_bn(input=0){
        //     var output = [];
        //     for (var i = 0; i < input.length; ++i) {
        //       if (numbers.hasOwnProperty(input[i])) {
        //         output.push(numbers[input[i]]);
        //       } else {
        //         output.push(input[i]);
        //       }
        //     }
        //     return output.join('');

        // },


        int_en_to_bn(text=0) {
            var result;
            if (text == '0') {
                result = '০';
            } else if (text == '1') {
                result = '১';
            } else if (text == '2') {
                result = '২';
            } else if (text == '3') {
                result = '৩';
            } else if (text == '4') {
                result = '৪';
            } else if (text == '5') {
                result = '৫';
            } else if (text == '6') {
                result = '৬';
            } else if (text == '7') {
                result = '৭';
            } else if (text == '8') {
                result = '৮';
            } else if (text == '9') {
                result = '৯';
            }
            return result;
        },




    },
    computed: {



        ...mapGetters({

            'Users' : 'getUpdateUser',
            'classess' : 'getUpdateClasses',
            'schoolSettings' : 'getschoolinfo',
        }),


    },
    mounted() {

    },




}
