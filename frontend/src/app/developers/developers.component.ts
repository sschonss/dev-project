import { Component, OnInit} from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { environment } from '../../environments/environments';

@Component({
  selector: 'app-developers',
  standalone: true,
  templateUrl: './developers.component.html',
  styleUrls: ['./developers.component.css'],
  imports: [CommonModule, FormsModule]
})

export class DevelopersComponent implements OnInit {
  developers: any[] = [];
  levels: any[] = [];
  newDeveloper = {
    name: '',
    gender: 'M',
    level_id: null,
    hobby: '',
    birth_date: ''
  };
  isLoading = true;
  errorMessage = '';

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.fetchDevelopers();
    this.fetchLevels();
  }

  getHeaders(): HttpHeaders {
    const token = localStorage.getItem('authToken');
    return new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });
  }

  fetchDevelopers(): void {
    const headers = this.getHeaders();

    this.http.get<any>(`${environment.apiUrl}/developers`, { headers }).subscribe({
      next: (response) => {
        this.developers = Array.isArray(response.data) ? response.data : [];
        this.isLoading = false;
        this.errorMessage = '';
      },
      error: (error) => {
        this.handleError(error);
        this.isLoading = false;
      }
    });
  }

  fetchLevels(): void {
    const headers = this.getHeaders();

    this.http.get<any>(`${environment.apiUrl}/levels`, { headers }).subscribe({
      next: (response) => {
        this.levels = Array.isArray(response.data) ? response.data : [];
      },
      error: (error) => {
        this.handleError(error);
      }
    });
  }

  addDeveloper() {
    const headers = this.getHeaders();

    this.http.post<any>(`${environment.apiUrl}/developers`, this.newDeveloper, { headers }).subscribe({
      next: (response) => {
        this.developers.push(response.data);
        this.newDeveloper = {
          name: '',
          gender: 'M',
          level_id: null,
          hobby: '',
          birth_date: ''
        };
        this.fetchDevelopers();
      },
      error: (error) => {
        this.handleError(error);
      }
    });
  }

  updateDeveloper(developer: any) {
    const headers = this.getHeaders();

    this.http.put<any>(`${environment.apiUrl}/developers/${developer.id}`, developer, { headers }).subscribe({
      next: (response) => {
        Object.assign(developer, response.data);
        developer.isEditing = false;
        this.fetchDevelopers()
      },
      error: (error) => this.handleError(error)
    });
  }

  deleteDeveloper(developer: any) {
    const headers = this.getHeaders();

    this.http.delete(`${environment.apiUrl}/developers/${developer.id}`, { headers }).subscribe({
      next: () => {
        this.developers = this.developers.filter(d => d.id !== developer.id);
      },
      error: (error) => this.handleError(error)
    });
  }

  editDeveloper(developer: any) {
    developer.isEditing = true;
  }

  cancelEdit(developer: any) {
    developer.isEditing = false;
  }

  handleError(error: any): void {
    const status = error?.status;

    switch (status) {
      case 400:
        this.errorMessage = 'Invalid input. Please check your input and try again.';
        break;
      case 401:
        this.errorMessage = 'You are not authorized to view this page. Please log in.';
        break;
      case 404:
        this.errorMessage = '';
        break;
      default:
        if (status >= 405 && status < 500) {
          this.errorMessage = 'Client error. Please check your input and try again.';
        } else if (status >= 500) {
          this.errorMessage = 'Server error. Please try again later.';
        }
        break;
    }

    console.error('Error fetching levels:', error);
  }
}
