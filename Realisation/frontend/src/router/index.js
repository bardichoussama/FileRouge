import AppLayout from '@/layout/AppLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('@/modules/EntretienIndividuel.module/views/Responsable/Dashboard.vue'),
                    meta: { requiresAuth: true, role: 'responsable' }  
                },
                {
                    path: '/entretien-individuel/checkin-forms',
                    name: 'checkin-forms',
                    component: () => import('@/modules/EntretienIndividuel.module/views/Responsable/CheckinForms.vue'),
                    meta: { requiresAuth: true, role: 'responsable' }  
                },
                {
                    path: '/entretien-individuel/checkin-forms/:id',
                    name: 'checkin-form-details',
                    component: () => import('@/modules/EntretienIndividuel.module/views/Responsable/CheckinFormDetails.vue'),
                    meta: { requiresAuth: true, role: 'responsable' }
                },
                {
                    path: '/entretien-individuel/checkin-forms/:formId/responses',
                    name: 'form-responses',
                    component: () => import('@/modules/EntretienIndividuel.module/views/Responsable/FormResponses.vue')
                },
                
                {
                    path: '/entretien-individuel/student/dashboard',
                    name: 'student-dashboard',
                    component: () => import('@/modules/EntretienIndividuel.module/views/Student/Dashboard.vue'),
                    meta: { requiresAuth: true, role: 'apprenant' }
                },
                {
                    path: '/entretien-individuel/student/my-submissions',
                    name: 'student-my-submissions',
                    component: () => import('@/modules/EntretienIndividuel.module/views/Student/MySubmissionsPage.vue'),
                    meta: { requiresAuth: true, role: 'apprenant' }
                },
               
            ]
        },
        {
            path: '/landing',
            name: 'landing',
            component: () => import('@/views/Landing.vue')
        },
        {
            path: '/notfound',
            name: 'notfound',
            component: () => import('@/views/NotFound.vue')
        },
        {
            path: '/auth/login',
            name: 'login',
            component: () => import('@/modules/EntretienIndividuel.module/views/auth/Login.vue')
        },
        {
            path: '/auth/access',
            name: 'accessDenied',
            component: () => import('@/modules/EntretienIndividuel.module/views/auth/Access.vue')
        },
        {
            path: '/auth/error',
            name: 'error',
            component: () => import('@/modules/EntretienIndividuel.module/views/auth/Error.vue')
        }
    ]
});

// Import auth store
// import { useAuthStore } from '@/stores/auth'

// Router guard to prevent flashing
router.beforeEach(async (to, from, next) => {
    // If using Pinia store, uncomment these lines:
    // const authStore = useAuthStore()
    // if (!authStore.isReady) {
    //     await authStore.initializeAuth()
    // }
    
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const requiredRole = to.meta.role;
    
    // Simple localStorage check (replace with store if using Pinia)
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const userRole = localStorage.getItem('role') || user.role;

    
    if (requiresAuth) {
        if (!token) {
            // User is not authenticated, redirect to login
            next('/auth/login');
            return;
        }
        
        // Check role if required
        if (requiredRole && userRole !== requiredRole) {
            // User doesn't have required role, redirect to access denied
            next('/auth/access');
            return;
        }
        
        // User is authenticated and has correct role
        next();
    } else {
        // Route doesn't require authentication
        if (to.path === '/auth/login' && token) {
            // If user is already logged in and tries to access login, redirect to dashboard
            if (userRole === 'apprenant') {
                next('/entretien-individuel/student/dashboard');
            } else {
                next('/'); // responsable dashboard
            }
        } else {
            next();
        }
    }
});

export default router;