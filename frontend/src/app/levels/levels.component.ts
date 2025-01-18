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
    if (status === 401) {
      this.errorMessage = 'You are not authorized to view this page. Please log in.';
    }
    if (status === 404) {
      this.errorMessage = '';
    }
    if (status >= 405 && status < 500) {
      this.errorMessage = 'Client error. Please check your input and try again.';
    }
    if (status >= 500) {
      this.errorMessage = 'Server error. Please try again later.';
    }

    console.error('Error fetching levels:', error);
  }

  deleteLevel(level: any) {
    const headers = this.getHeaders();
    this.http.delete(`${environment.apiUrl}/levels/${level.id}`, { headers }).subscribe({
      next: () => {
        this.levels = this.levels.filter(l => l.id !== level.id);
      },
      error: (error) => this.handleError(error)
    });
  }

  updateLevel(level: any) {
    const headers = this.getHeaders();
    this.http.put(`${environment.apiUrl}/levels/${level.id}`, { level: level.level }, { headers }).subscribe({
      next: () => {
        level.isEditing = false;
      },
      error: (error) => this.handleError(error)
    });
  }

  editLevel(level: any) {
    level.isEditing = true;
  }

  cancelEdit(level: any) {
    level.isEditing = false;
  }
}
