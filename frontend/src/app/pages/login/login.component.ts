import { Component } from '@angular/core';
import { ApiService } from '../../services/api.service';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})
export class LoginComponent {
  email:string = '';
  password:string = '';
  errorMessage: string = '';

  constructor(private apiService: ApiService, private router: Router) {}

  login() {
    this.apiService.login({ email: this.email, password: this.password }).subscribe({
      next: (response) => {
        localStorage.setItem('jwtToken', response.data.token);
        this.router.navigate(['/quotation']);
      },
      error: (error) => {
        this.errorMessage = error.error.message;
      }
    });
  }
}
