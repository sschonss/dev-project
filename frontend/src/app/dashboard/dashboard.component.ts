import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
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
