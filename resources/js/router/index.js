import { createRouter, createWebHistory } from "vue-router";
import Layout from "../components/layout.vue";
import NewShortenUrl from "../components/NewShortenUrl.vue";
import ShortenedUrlsList from "../components/ShortenedUrlsList.vue";
import ShortUrlStats from "../components/ShortUrlStats.vue";

const routes = [
    {
        path: "",
        component: Layout,
        children: [
            { path: "", component: NewShortenUrl },
            { path: "/list", component: ShortenedUrlsList },
            { path: "/stats", component: ShortUrlStats },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
