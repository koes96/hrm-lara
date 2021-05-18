<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>
          <div class="card-body">
            <datatable :columns="columns" :data="rows"></datatable>
            <datatable-pager
              v-model="page"
              type="abbreviated"
              :per-page="per_page"
            >
            </datatable-pager>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { VuejsDatatableFactory } from "vuejs-datatable";
export default {
  components: { VuejsDatatableFactory },
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      columns: [
        { label: "id", field: "id" },
        { label: "Nama", field: "name" },
        { label: "Email", field: "email" },
        { label: "Aksi", field: "" },
      ],
      rows: [],
      page: 1,
      per_page: 10,
    };
  },
  methods: {
    getPosts: function () {
      axios.get("api/user").then(
        function (response) {
          this.rows = response.data;
        }.bind(this)
      );
    },
  },
  created: function () {
    this.getPosts();
  },
};
</script>
