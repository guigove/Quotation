import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { ApiService } from '../../services/api.service';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { QuotationResponse } from '../../interfaces/quotation-response.interface';

@Component({
  selector: 'app-quotation',
  imports: [FormsModule, CommonModule],
  templateUrl: './quotation.component.html',
  styleUrl: './quotation.component.scss'
})
export class QuotationComponent {
  startDate: string = '';
  endDate: string = '';
  age: string = '';
  currency: string = 'EUR';
  quotationResponse: QuotationResponse|null = null;
  errorMessage: string = '';

  constructor(private router: Router, private apiService: ApiService) {}

  getQuotation() {
    const requestData = {
      start_date: this.startDate,
      end_date: this.endDate,
      age: this.age,
      currency_id: this.currency,
    };

    this.apiService.quotation(requestData).subscribe(
      (response) => {
        this.quotationResponse = response.data;
        this.errorMessage = '';
      },
      (error) => {
        this.errorMessage = error.error.message;
        this.quotationResponse = null
      }
    );
  }
}
