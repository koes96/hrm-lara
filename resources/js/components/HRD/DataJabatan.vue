<template>
  <div class="users-style">
    <div style="margin-bottom: 20px">
      <h2>Laravel and VueJS Datatable from Scratch</h2>
    </div>
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

      <div class="form-group">
        <multiselect
          v-model="selectedCountries"
          id="ajax"
          label="name"
          track-by="name"
          placeholder="Type to search"
          open-direction="bottom"
          :options="countries"
          :multiple="true"
          :searchable="true"
          :loading="isLoading"
          :internal-search="false"
          :clear-on-select="false"
          :close-on-select="false"
          :options-limit="15"
          :limit="3"
          :limit-text="limitText"
          :max-height="600"
          :show-no-results="false"
          :hide-selected="true"
          @search-change="getUsers"
        ></multiselect>
      </div>
      <input
        class="form-control input"
        type="text"
        v-model="search"
        placeholder="Search..."
        @input="resetPagination()"
        style="width: 250px"
      />

      <button class="btn btn-primary btn-sm radius-15" @click="alldeleteUser">
        Delete User
      </button>

      <select
        v-model="select"
        class="form-control"
        style="margin-bottom: 10px"
        @change="alldeleteUser"
      >
        <option value="">Select</option>
        <option value="">Delete All</option>
      </select>

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
        <tr v-for="user in paginatedUsers" :key="user.id">
          <td>
            <input
              type="checkbox"
              v-model="deleteItems"
              :value="`${user.id}`"
            />
          </td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.id }}</td>
          <td>{{ user.created_at }}</td>
          <td>
            <!-- <a class="btn btn-primary btn-sm radius-15" @click="deleteUser(user.id)">Delete User</a> -->
            <button
              class="btn btn-primary btn-sm radius-15"
              @click="deleteUser(user.id)"
            >
              <!-- -->
              Delete User
            </button>
            <button
              class="btn btn-info btn-sm radius-15"
              @click="
                edit(
                  user.id,
                  user.name,
                  user.email,
                  user.role_id,
                  user.password
                )
              "
            >
              Edit User
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
          {{ filteredUsers.length }}
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
                <input
                  class="form-control"
                  v-model="form.name"
                  type="text"
                  name=""
                  placeholder="Nama Pengguna"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <input
                  class="form-control"
                  type="email"
                  v-model="form.email"
                  placeholder="Email"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />

                <has-error :form="form" field="email"></has-error>
              </div>
              <div class="form-group">
                <input
                  class="form-control"
                  type="password"
                  v-model="form.password"
                  placeholder="Password"
                />
              </div>
              <div class="form-group">
                <select
                  class="form-control"
                  v-model="form.role_id"
                  :class="{ 'is-invalid': form.errors.has('role_id') }"
                >
                  <option value>Pilih Role</option>
                  <!-- <option
                    v-for="item in levels"
                    :key="item.id"
                    :value="item.id"
                  >
                    {{ item.role }}
                  </option> -->
                  <option value="1">Haha</option>
                </select>
                <has-error :form="form" field="role_id"></has-error>
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
    this.getUsers();
    Fire.$on("reloadUsers", () => {
      this.getUsers();
    });
  },
  data() {
    let sortOrders = {};
    let columns = [
      { label: "Name", name: "name" },
      { label: "Email", name: "email" },
      { label: "Date", name: "id" },
      { label: "Date Added", name: "created_at" },
    ];
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return {
      selectedCountries: [],
      countries: {},
      isLoading: false,
      users: [],
      columns: columns,
      sortKey: "created_at",
      sortOrders: sortOrders,
      length: 10,
      search: "",
      all_select: false,
      deleteItems: [],
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
        name: "",
        role_id: "",
        email: "",
        password: "",
      }),
    };
  },
  methods: {
    limitText(count) {
      return `and ${count} other countries`;
    },
    clearAll() {
      this.selectedCountries = [];
    },
    showModal() {
      this.form.reset();
      $("#exampleModal").modal("show");
    },
    closeModal() {
      this.form.reset();
      $("#exampleModal").modal("hide");
    },
    simpandata() {
      this.loading = true;
      this.disabled = true;
      this.form
        .post("api/user")
        .then(() => {
          Fire.$emit("reloadUsers");
          this.closeModal();
          Swal.fire("Created!", "Data is Saved", "success");
          this.loading = false;
          this.disabled = false;
        })
        .catch();
    },
    edit(id, name, email, roleid) {
      this.showModal();
      this.form.id = id;
      this.form.name = name;
      this.form.email = email;
      this.form.role_id = roleid;
    },
    deleteUser(id) {
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
          //Send Request to server
          //   this.form.deleteuser('/users/${id}/delete')
          axios
            .delete(`api/user/` + id)
            .then(() => {
              Fire.$emit("reloadUsers");
              Swal.fire("Deleted!", "User deleted successfully", "success");
              // this.deleteUser();
              // this.deleteItems = []
              //       this.all_select == true ?
              //            this.all_select = false : this.all_select = true;
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
    alldeleteUser() {
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
          //Send Request to server
          //   this.form.deleteuser('/users/${id}/delete')
          axios
            .post(`api/user/` + this.deleteItems)
            .then(() => {
              Fire.$emit("reloadUsers");
              Swal.fire("Deleted!", "User deleted successfully", "success");
              // this.getUser();
              this.deleteItems = [];
              this.all_select == false;
              // ? (this.all_select = false)
              // : (this.all_select = true);
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
        this.users.forEach((user) => {
          this.deleteItems.push(user.id);
        });
      } else {
        this.all_select = false;
        this.deleteItems = [];
      }
    },
    // 	created() {
    //       this.getUser()
    //   },

    getUsers() {
      axios
        .get("api/user/", { params: this.tableShow })
        .then((response) => {
          console.log("The data: ", response.data);
          this.users = response.data;
          this.pagination.total = this.users.length;
        })
        .catch((errors) => {
          console.log(errors);
        });

      axios.get("api/multiselect").then(({ data }) => (this.countries = data));
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
    filteredUsers() {
      let users = this.users;
      if (this.search) {
        users = users.filter((row) => {
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
        users = users.slice().sort((a, b) => {
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
      return users;
    },
    paginatedUsers() {
      return this.paginate(
        this.filteredUsers,
        this.length,
        this.pagination.currentPage
      );
    },
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
