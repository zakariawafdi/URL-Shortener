import { createRouter, createWebHistory } from "vue-router";
import NewShortenUrl from "../components/NewShortenUrl.vue";
import ShortenedUrlsList from "../components/ShortenedUrlsList.vue";
import Layout from "../components/layout.vue";

const routes = [
    {
        path: "",
        component: Layout,
        children: [
            { path: "", component: NewShortenUrl },
            { path: "/list", component: ShortenedUrlsList },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
