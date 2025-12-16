<template>
    <div>
                        <loader v-if="preloader==true" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" disableScrolling="false" name="circular"></loader>

        <div class="breadcrumbs-area">
            <h3>Bulk Payments</h3>
            <ul>
                <li><a href="">Home</a></li>
                <li>Bulk Fees Collection</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">

                <div class="heading-layout1">
                    <div class="item-title">
                        <router-link class="btn-fill-md radius-4 text-light bg-orange-red mb-3" to="">
                            GO BACK
                        </router-link>
                    </div>
                </div>

                <!-- Global Amount Input -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label><b>Amount (for all selected students)</b></label>
                        <input type="number" class="form-control" v-model="amount" required placeholder="Enter amount">
                    </div>
                </div>

                <!-- Student List -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th><input type="checkbox" v-model="selectAll" @change="toggleAll"></th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Roll</th>
                                <th>Admission ID</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="stu in students" :key="stu.id">
                                <td>
                                    <input type="checkbox" v-model="selectedStudents" :value="stu">
                                </td>

                                <td>{{ stu.StudentID }}</td>
                                <td>{{ stu.StudentName }}</td>
                                <td>{{ stu.StudentClass }}</td>
                                <td>{{ stu.StudentRoll }}</td>
                                <td>{{ stu.AdmissionID }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Payment Button -->
                <button
                    class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark mt-3"
                    :disabled="selectedStudents.length == 0"
                    @click="submitBulkPayment"
                >
                    Pay Selected ({{ selectedStudents.length }})
                </button>

            </div>
        </div>

    </div>
</template>


<script>
export default {
    data() {
        return {
            preloader: true,

            students: [],
            selectedStudents: [],
            selectAll: false,

            amount: null,

            type: null,
            month: null,
            year: null,
            classname: null,
        }
    },

    methods: {
        loadStudents() {
            this.preloader = true;
            let url = `/api/students/single?filter[StudentClass]=${this.classname}&filter[Year]=${this.year}&filter[StudentStatus]=Active`;

            axios.get(url)
                .then(({ data }) => {
                    this.students = data;
                    this.preloader = false;
                })
                .catch(() => {
                    this.preloader = false;
                });
        },

        toggleAll() {
            if (this.selectAll) {
                this.selectedStudents = [...this.students];
            } else {
                this.selectedStudents = [];
            }
        },

        async submitBulkPayment() {
            if (!this.amount || this.amount <= 0) {
                Notification.error("Amount is required!");
                return;
            }

            if (this.selectedStudents.length === 0) {
                Notification.error("No student selected!");
                return;
            }

            this.preloader = true;

            let type_name = this.$route.query.type_name;

            let payloadList = this.selectedStudents.map(stu => ({
                id: null,
                school_id: stu.school_id,
                type: this.type,
                type_name: type_name,
                StudentClass: stu.StudentClass,
                StudentRoll: stu.StudentRoll,
                StudentID: stu.StudentID,
                AdmissionID: stu.AdmissionID,
                StudentName: stu.StudentName,

                amount: this.amount, // SAME AMOUNT FOR ALL

                method: "Handcash",
                status: "Paid",
                date: User.dateformat()[0],
                month: this.month,
                year: this.year,
                formtype: "create"
            }));

            for (let formData of payloadList) {
                await axios.post(`/api/students/payments/submit`, formData).catch(() => {});
            }

            Notification.success("Bulk payment completed!");

            this.preloader = false;

            this.$router.push({
                name: "paymentsearch",
                params: {
                    classname: this.classname,
                    year: this.year,
                    month: this.month,
                    type: this.type
                },
                query: { type_name }
            });
        }
    },

    mounted() {
        this.type = this.feesconvert(this.$route.params.type);
        this.month = this.$route.params.month;
        this.year = this.$route.params.year;
        this.classname = this.$route.params.classname;

        this.loadStudents();
    }
}
</script>


<style scoped>
.table input[type="checkbox"] {
    width: 20px;
    height: 20px;
}
</style>
