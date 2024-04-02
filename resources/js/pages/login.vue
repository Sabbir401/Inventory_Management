<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4 mt-5">
        <div class="border border-dark rounded p-4">
          <h1 class="text-center">Login</h1>
          <p class="text-danger" v-if="error">{{ error }}</p>
          <form @submit.prevent="login">
            <div class="from-group">
              <label for="email">Email Address:</label>
              <input
                type="email"
                class="form-control"
                id="email"
                v-model="form.email"
              />
            </div>
            <div class="from-group">
              <label for="password">Password</label>
              <input
                type="password"
                class="form-control mb-1"
                id="password"
                v-model="form.password"
              />
            </div>
            <div class="row mb-3">
              <div class="col-lg-6">Forget Password?</div>
              <div class="col-lg-6 d-flex justify-content-end">
                <router-link class="text-primary" :to="{ name: 'Register' }"
                  >Sign-Up</router-link
                >
              </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%">
              Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

export default {
  setup() {
    const router = useRouter();
    const store = useStore();

    let form = reactive({
      email: "",
      password: "",
    });

    let error = ref("");

    const login = async () => {
      await axios.post("/api/login", form).then((res) => {
        if (res.data.success) {
        //   localStorage.setItem("token", res.data.data.token);
          store.dispatch("setToken", res.data.data.token);
          store.dispatch("setUserId", res.data.userid);
          router.push({ name: "Dashboard" });
        } else {
          error.value = res.data.message;
        }
      });
    };
    return {
      form,
      login,
      error,
    };
  },
};
</script>
