<template>
  <div class="users-style">
    <div class="table-style">
      <div class="card-tools">
        <button
          type="button"
          class="btn btn-primary btn-sm radius-10 mb-1"
          @click="showModal"
        >
          Add Data
        </button>
      </div>

      <input
        class="form-control input"
        type="text"
        v-model="search"
        placeholder="Search..."
        @input="resetPagination()"
        style="width: 250px"
      />

      <button class="btn btn-primary btn-sm radius-15" @click="alldeleteDatas">
        Delete Data
      </button>

      <div class="control">
        <div class="select">
          <select
            class="form-control"
            v-model="length"
            @change="resetPagination()"
          >
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
          </select>
        </div>
      </div>
    </div>
    <table class="table table-bordered table-responsive">
      <thead>
        <tr>
          <th>
            <input
              type="checkbox"
              @click="select_all_via_check_box"
              v-model="all_select"
            />
            <span>
              {{ all_select == true ? "Uncheck All" : "Select All" }}
            </span>
          </th>
          <th
            v-for="column in columns"
            :key="column.name"
            @click="sortBy(column.name)"
            :class="
              sortKey === column.name
                ? sortOrders[column.name] > 0
                  ? 'sorting_asc'
                  : 'sorting_desc'
                : 'sorting'
            "
            style="width: 40%; cursor: pointer"
          >
            {{ column.label }}
          </th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="datax in paginatedDatas" :key="datax.idakses">
          <td>
            <input
              type="checkbox"
              v-model="deleteDatas"
              :value="`${datax.idakses}`"
            />
          </td>
          <td>{{ datax.idakses }}</td>
          <td>{{ datax.name }}</td>
          <di v-for="menus in datax.menu_id" :key="menus">
            <td v-for="men in menus" :key="men.id">
              {{ men.menu }}
            </td>
          </di>
          <td>
            <!-- <a class="btn btn-primary btn-sm radius-15" @click="deleteUser(user.id)">Delete User</a> -->
            <button
              class="btn btn-primary btn-sm radius-15"
              @click="deleteData(datax.idakses)"
            >
              <!-- -->
              Delete Datas
            </button>
            <button
              class="btn btn-info btn-sm radius-15"
              @click="
                edit(
                  datax.idakses,
                  (Namas.name = datax.name),
                  (Namas.id = datax.iduser),
                  (Gudang.id = datax.idmains),
                  (Gudang.menu = datax.menu)
                )
              "
            >
              Edit Data
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div>
      <nav class="pagination" v-if="!tableShow.showdata">
        <span class="page-stats"
          >{{ pagination.from }} - {{ pagination.to }} of
          {{ pagination.total }}</span
        >
        <a
          v-if="pagination.prevPageUrl"
          class="btn btn-sm btn-primary pagination-previous"
          @click="--pagination.currentPage"
        >
          Prev
        </a>
        <a class="btn btn-sm btn-primary pagination-previous" v-else disabled>
          Prev
        </a>
        <a
          v-if="pagination.nextPageUrl"
          class="btn btn-sm pagination-next"
          @click="++pagination.currentPage"
        >
          Next
        </a>
        <a class="btn btn-sm btn-primary pagination-next" v-else disabled>
          Next
        </a>
      </nav>
      <nav class="pagination" v-else>
        <span class="page-stats">
          {{ pagination.from }} - {{ pagination.to }} of
          {{ filteredDatas.length }}
          <span v-if="`filteredUsers.length < pagination.total`"></span>
        </span>
        <a
          v-if="pagination.prevPage"
          class="btn btn-sm btn-primary pagination-previous"
          @click="--pagination.currentPage"
        >
          Prev
        </a>
        <a class="btn btn-sm pagination-previous btn-primary" v-else disabled>
          Prev
        </a>
        <a
          v-if="pagination.nextPage"
          class="btn btn-sm btn-primary pagination-next"
          @click="++pagination.currentPage"
        >
          Next
        </a>
        <a class="btn btn-sm pagination-next btn-primary" v-else disabled>
          Next
        </a>
      </nav>
    </div>
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
              @click="closeModal()"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form
            @submit.prevent="simpandata()"
            @keydown="form.onKeydown($event)"
          >
            <div class="modal-body">
              <div class="form-group">
                <input class="form-control" type="hidden" v-model="form.id" />
              </div>
              <div class="form-group">
                <multiselect
                  v-model="form.role_id"
                  id="ajax"
                  label="name"
                  track-by="name"
                  placeholder="Type to search"
                  open-direction="bottom"
                  :options="usersss"
                  :multiple="false"
                  :searchable="true"
                  :loading="isLoading"
                  :internal-search="true"
                  :clear-on-select="false"
                  :close-on-select="true"
                  :options-limit="5"
                  :limit="3"
                  :limit-text="limitTextxx"
                  :max-height="600"
                  :show-no-results="false"
                  :hide-selected="true"
                  @search-change="getUsersSelect"
                  @change="getUsersSelect"
                >
                </multiselect>
              </div>
              <div class="form-group">
                <multiselect
                  v-model="form.menu_id"
                  name="menu_id"
                  id="ajax"
                  label="menu"
                  track-by="menu"
                  placeholder="Menu ID"
                  open-direction="bottom"
                  :options="countries"
                  :multiple="true"
                  :searchable="true"
                  :loading="isLoading"
                  :internal-search="true"
                  :clear-on-select="false"
                  :close-on-select="false"
                  :options-limit="5"
                  :limit="3"
                  :limit-text="limitText"
                  :max-height="600"
                  :show-no-results="false"
                  :hide-selected="true"
                  :value="Gudang"
                  @search-change="getMenuSelect"
                >
                </multiselect>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="submit"
                class="btn btn-primary"
                :disabled="form.busy"
              >
                Save changes
              </button>
              <button
                type="button"
                class="btn btn-secondary"
                @click="closeModal()"
              >
                Close
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Multiselect from "vue-multiselect";
//import { ajaxFindCountry } from './countriesApi'
// let ajaxFindCountry = "api/user/";
export default {
  components: { Multiselect },
  created() {
    this.getDatas();
    Fire.$on("reloadDatas", () => {
      this.getDatas();
    });
  },
  data() {
    let sortOrders = {};
    let columns = [
      { label: "id", name: "id" },
      { label: "role_id", name: "role_id" },
      { label: "menu_id", name: "menu_id" },
    ];
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return {
      Namas: {
        id: "",
        name: "",
      },
      Gudang: {
        menu: "",
      },
      selectedCountries: [],
      countries: {},
      selectedUsersss: [],
      usersss: {},
      isLoading: false,
      datas: [],
      columns: columns,
      sortKey: "id",
      sortOrders: sortOrders,
      length: 10,
      search: "",
      all_select: false,
      deleteDatas: [],
      multiselect: [],
      select: "",
      tableShow: {
        showdata: true,
      },
      pagination: {
        currentPage: 1,
        total: "",
        nextPage: "",
        prevPage: "",
        from: "",
        to: "",
      },
      form: new Form({
        id: "",
        role_id: "",
        menu_id: "",
      }),
    };
  },
  methods: {
    limitText(count) {
      return `and ${count} other countries`;
    },
    limitTextxx(count) {
      return `and ${count} other usersss`;
    },
    clearAll() {
      this.selectedmultidatas = [];
    },
    showModal() {
      this.form.reset();
      $("#exampleModal").modal("show");
    },
    closeModal() {
      this.form.reset();
      $("#exampleModal").modal("hide");
    },
    // autoselect(value, id){
    //   alert(value.name)

    // },
    simpandata() {
      this.loading = true;
      this.disabled = true;
      if (this.form.id == "") {
        this.form
          .post("api/akses-menu")
          .then(() => {
            Fire.$emit("reloadDatas");
            this.closeModal();
            Swal.fire("Created!", "Data is Saved", "success");
            this.loading = true;
            this.disabled = true;
          })
          .catch();
      } else {
        this.form
          .put("api/akses-menu/" + this.form.id)
          .then(() => {
            Fire.$emit("reloadDatas");
            this.closeModal();
            Swal.fire("Update!", "Data is Update", "success");
            this.loading = true;
            this.disabled = true;
          })
          .catch();
      }
    },
    edit(id) {
      this.showModal();
      this.form.id = id;
      this.form.role_id = this.Namas;
      this.form.menu_id = this.Gudang;
    },
    deleteData(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this! ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete(`api/main-menu/` + id)
            .then(() => {
              Fire.$emit("reloadDatas");
              Swal.fire("Deleted!", "User deleted successfully", "success");
            })
            .catch(() => {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: "<a href>Why do I have this issue?</a>",
              });
            });
        }
      });
    },
    alldeleteDatas() {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`api/main-menu/` + this.deleteDatas)
            .then(() => {
              Fire.$emit("reloadDatas");
              Swal.fire("Deleted!", "User deleted successfully", "success");
              this.deleteDatas = [];
              this.all_select == false;
            })
            .catch(() => {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: "<a href>Why do I have this issue?</a>",
              });
            });
        }
      });
    },
    select_all_via_check_box() {
      if (this.all_select == false) {
        this.all_select = true;
        this.datas.forEach((datas) => {
          this.deleteDatas.push(datas.id);
        });
      } else {
        this.all_select = false;
        this.deleteDatas = [];
      }
    },
    getUsersSelect() {
      this.isLoading = true;
      axios.get("api/multiselect").then(({ data }) => (this.usersss = data));
      this.isLoading = false;
    },
    getMenuSelect() {
      this.isLoading = true;
      axios
        .get("api/multimainmenu")
        .then(({ data }) => (this.countries = data));
      this.isLoading = false;
    },

    getDatas() {
      axios
        .get("api/akses-menu/", { params: this.tableShow })
        .then((response) => {
          console.log("The data: ", response.data);
          this.datas = response.data;
          this.pagination.total = this.datas.length;
        })
        .catch((errors) => {
          console.log(errors);
        });

      axios.get("api/multiselect").then(({ data }) => (this.usersss = data));
      axios
        .get("api/multimainmenu")
        .then(({ data }) => (this.countries = data));
    },
    paginate(array, length, pageNumber) {
      this.pagination.from = array.length ? (pageNumber - 1) * length + 1 : " ";
      this.pagination.to =
        pageNumber * length > array.length ? array.length : pageNumber * length;
      this.pagination.prevPage = pageNumber > 1 ? pageNumber : "";
      this.pagination.nextPage =
        array.length > this.pagination.to ? pageNumber + 1 : "";
      return array.slice((pageNumber - 1) * length, pageNumber * length);
    },
    resetPagination() {
      this.pagination.currentPage = 1;
      this.pagination.prevPage = "";
      this.pagination.nextPage = "";
    },
    sortBy(key) {
      this.resetPagination();
      this.sortKey = key;
      this.sortOrders[key] = this.sortOrders[key] * -1;
    },
    getIndex(array, key, value) {
      return array.findIndex((i) => i[key] == value);
    },
  },

  computed: {
    filteredDatas() {
      let datas = this.datas;
      if (this.search) {
        datas = datas.filter((row) => {
          return Object.keys(row).some((key) => {
            return (
              String(row[key])
                .toLowerCase()
                .indexOf(this.search.toLowerCase()) > -1
            );
          });
        });
      }
      let sortKey = this.sortKey;
      let order = this.sortOrders[sortKey] || 1;
      if (sortKey) {
        datas = datas.slice().sort((a, b) => {
          let index = this.getIndex(this.columns, "name", sortKey);
          a = String(a[sortKey]).toLowerCase();
          b = String(b[sortKey]).toLowerCase();
          if (this.columns[index].type && this.columns[index].type === "date") {
            return (
              (a === b
                ? 0
                : new Date(a).getTime() > new Date(b).getTime()
                ? 1
                : -1) * order
            );
          } else if (
            this.columns[index].type &&
            this.columns[index].type === "number"
          ) {
            return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
          } else {
            return (a === b ? 0 : a > b ? 1 : -1) * order;
          }
        });
      }
      return datas;
    },
    paginatedDatas() {
      return this.paginate(
        this.filteredDatas,
        this.length,
        this.pagination.currentPage
      );
    },
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
