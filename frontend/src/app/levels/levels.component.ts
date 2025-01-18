import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environments';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-levels',
  templateUrl: './levels.component.html',
  styleUrls: ['./levels.component.css'],
  standalone: true,
  imports: [CommonModule, FormsModule]
})
export class LevelsComponent implements OnInit {
  levels: any[] = [];
  isLoading = true;
  errorMessage = '';
  newLevelName = '';

  constructor(private http: HttpClient) {}

  getHeaders(): HttpHeaders {
    const token = localStorage.getItem('authToken');
    return new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });
  }

  ngOnInit(): void {
    this.fetchLevels();
  }

  fetchLevels(): void {
    this.errorMessage = '';
    const headers = this.getHeaders();
    this.http.get<any>(`${environment.apiUrl}/levels`, { headers }).subscribe({
      next: (response) => {
        this.levels = Array.isArray(response.data) ? response.data : [];
        this.isLoading = false;
      },
      error: (error) => {
        this.handleError(error);
        this.isLoading = false;
      }
    });
  }

  addLevel() {
    this.errorMessage = '';
    const headers = this.getHeaders();
    this.http.post<any>(`${environment.apiUrl}/levels`, { level: this.newLevelName }, { headers }).subscribe({
      next: (response: {data: any, message: string, status: string}) => {
        this.levels.push(response.data);
        this.newLevelName = '';
      },
      error: (error) => {
        this.handleError(error);
      }
    });
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
        this.errorMessage = 'Resource not found. Please try again.';
        break;
      default:
        if (status >= 405 && status < 500) {
          this.errorMessage = 'Client error. Please check your input and try again.';
        } else if (status >= 500) {
          this.errorMessage = 'Server error. Please try again later.';
        } else {
          this.errorMessage = '';
        }
        break;
    }
    console.error('Error:', error);
  }

  deleteLevel(level: any) {
    this.errorMessage = '';
    const headers = this.getHeaders();
    this.http.delete(`${environment.apiUrl}/levels/${level.id}`, { headers }).subscribe({
      next: () => {
        this.levels = this.levels.filter(l => l.id !== level.id);
      },
      error: (error) => this.handleError(error)
    });
  }

  updateLevel(level: any) {
    this.errorMessage = '';
    const headers = this.getHeaders();
    this.http.put(`${environment.apiUrl}/levels/${level.id}`, { level: level.level }, { headers }).subscribe({
      next: () => {
        level.isEditing = false;
      },
      error: (error) => this.handleError(error)
    });
  }

  editLevel(level: any) {
    this.errorMessage = '';
    level.isEditing = true;
  }

  cancelEdit(level: any) {
    level.isEditing = false;
    this.errorMessage = '';
  }
}
