import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environments';

@Component({
  selector: 'app-level-form',
  templateUrl: './level-form.component.html',
  styleUrls: ['./level-form.component.css'],
})
export class LevelFormComponent {
  levelName: string = '';
  levels: any[] = [];
  message: string = '';

  constructor(private http: HttpClient) {}

  onSubmit(event: Event) {
    event.preventDefault();

    const levelData = {
      name: this.levelName,
    };

    this.http.post(`${environment.apiUrl}/levels`, levelData).subscribe({
      next: (response) => {
        console.log('Level saved:', response);
        this.levelName = '';
      },
      error: (err) => {
        console.error('Error saving level:', err);
      },
    });
  }

  onSearch(event: Event) {
    event.preventDefault();
  }

  onDelete(levelId: number, event: Event) {
    event.preventDefault();

    this.http.delete(`${environment.apiUrl}/levels/${levelId}`).subscribe({
      next:(response) => {
        console.log('Level deleted:', response);
        this.onSearch(event);
      },
      error: (err) => {
        console.error('Error deleting level:', err);
      },
    });
  }

  onUpdate(levelId: number, event: Event) {
    event.preventDefault();

    const levelData = {
      name: this.levelName,
    };

    this.http
      .put(`${environment.apiUrl}/levels/${levelId}`, levelData)
      .subscribe({
        next: (response) => {
          console.log('Level updated:', response);
          this.levelName = '';
          this.onSearch(event);
        },
        error: (err) => {
          console.error('Error updating level:', err);
        },
      });
  }
}
