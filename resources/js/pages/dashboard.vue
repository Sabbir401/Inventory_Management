<template>
  <inventory
    :isOpen="isModalOpened"
    :edit="selecteddata"
    :updateinfo="heading"
    @modal-close="closeModal"
    @submit="submitHandler"
    name="first-modal"
  />
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-dark my-2" @click="logout">
        Logout
      </button>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="d-flex">
          <div class="mr-auto p-2">
            <div class="row">
              <h4 class="card-title m-2">Inventory List</h4>
              <button
                @click="choose"
                style="float: left"
                type="button"
                class="btn btn-success btn-icon"
              >
                Add New
              </button>
            </div>
          </div>
          <div class="p-2">
            <input
              type="text"
              class="form-control"
              id="exampleInputUsername1"
              placeholder="Search..."
            />
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Date</th>
                <th>Inventory Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Operation</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(inven, index) in inventoryData"
                :key="inven.id"
              >
                <td>{{ index + 1 }}</td>
                <td>{{ inven.Date }}</td>
                <td>{{ inven.Name }}</td>
                <td>{{ inven.Description }}</td>
                <td>{{ inven.Status }}</td>
                <td>
                  <button
                    class="btn btn-success mr-2"
                    @click="editHandler(inven.id)"
                  >
                    Edit
                  </button>
                  <button
                    class="btn btn-primary mr-2"
                    @click="router.push(`/inventry/${inven.id}`)"
                  >
                    Details
                  </button>
                  <button
                    class="btn btn-danger"
                    @click="deleteInventory(inven.id)"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <br />
          <!-- <Bootstrap5Pagination
            :data="stores"
            @pagination-change-page="getData"
          /> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from "vue-router";
import { onMounted, ref } from "vue";
import { useStore } from "vuex";
import inventory from "./Component/createInventory.vue";

// import router from '../router';

export default {
  components: {
    inventory,
  },
  setup() {
    const router = useRouter();
    const user = ref([]);
    const store = useStore();
    const isModalOpened = ref(false);
    const selecteddata = ref(null);
    const heading = ref(null);
    const inventoryData = ref(null);

    function logout() {
      store.dispatch("removeToken");
      //   localStorage.removeItem("token");
      router.push({ name: "Login" });
    }

    const openModal = () => {
      isModalOpened.value = true;
    };

    const closeModal = () => {
      isModalOpened.value = false;
    };

    const choose = () => {
      heading.value = "Insert";
      openModal();
    };

    const editHandler = async (id) => {
      try {
        const response = await axios.get(`api/inventory/${id}/edit`);
        selecteddata.value = response.data;
        heading.value = "Update";
        openModal();
      } catch (err) {
        console.error("Error fetching store data for editing:", err);
      }
    };

    const deleteInventory = async (id) => {
      try {
        const response = await axios.delete(`api/inventory/${id}`);
        getData();
      } catch (err) {
        console.error("Error fetching store data for editing:", err);
      }
    };

    const getData = async () => {
      try {
        const res = await axios.get('/api/get-session-data');
        const userID = res.data.userId;

        const responseInventory = await axios.get(`/api/inventory/${userID}`);
        inventoryData.value = responseInventory.data;

      } catch (error) {
        console.error("Error fetching data");
      }
    };

    const submitHandler = async () => {
      await getData();
    };

    onMounted(() => getData());

    return {
      logout,
      user,
      isModalOpened,
      choose,
      submitHandler,
      closeModal,
      openModal,
      heading,
      selecteddata,
      inventoryData,
      editHandler,
      deleteInventory,
      router,
      inventory
    };
  },
};
</script>
