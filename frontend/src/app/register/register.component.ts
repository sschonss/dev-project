import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { environment } from '../../environments/environments';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  standalone: true,
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  imports: [FormsModule, CommonModule],
})
export class RegisterComponent {
  name: string = '';
  email: string = '';
  password: string = '';
  confirmPassword: string = '';
  message: string = '';

  constructor(private http: HttpClient, private router: Router) {}

  onSubmit(event: Event) {
    event.preventDefault();

    if (this.password !== this.confirmPassword) {
      this.message = 'Passwords do not match!';
      return;
    }

    const userData = {
      name: this.name,
      email: this.email,
      password: this.password,
      password_confirmation: this.confirmPassword,
    };

    this.http.post(`${environment.apiUrl}/register`, userData).subscribe({
      next: (response) => {
        console.log('User registered successfully');
        this.message = 'User registered successfully!';
        setTimeout(() => {
          this.router.navigate(['/']);
        }, 2000);
      },
      error: (err) => {
        console.error('Error registering user:', err);
        this.message = 'Failed to register user.';
      },
    });
  }
}
