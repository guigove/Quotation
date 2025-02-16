import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { QuotationComponent } from './pages/quotation/quotation.component';

export const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'quotation', component: QuotationComponent },
    { path: '**', component: LoginComponent },
];
