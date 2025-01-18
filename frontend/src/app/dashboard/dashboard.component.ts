import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { LevelsComponent } from '../levels/levels.component';
import { DevelopersComponent } from '../developers/developers.component';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css', '../../styles.css'],
  imports: [CommonModule, LevelsComponent, DevelopersComponent]
})
export class DashboardComponent {
  activeTab: 'developers' | 'levels' = 'developers';

  constructor(private router: Router) {}

  onLogout() {
    localStorage.removeItem('authToken');
    this.router.navigate(['/login']);
  }

  switchTab(tab: 'developers' | 'levels') {
    this.activeTab = tab;
  }
}
