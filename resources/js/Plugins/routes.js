import Login from "@/Pages/Login";
import AppLayout from "@/Layouts/AppLayout";

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'login',
                    component: Login,
                },
            ]
        }
    ]
}
