# Pharmacy Management System with AI & OCR

A Laravel-based Pharmacy Management System that integrates **AI** and **OCR** to automate prescription processing, doctor's BMDC validation, and symptom-based medicine suggestions.

This project was developed as part of the **CSE311 – Database Management Systems** course.

---

## 🔍 Key Features

### 1. Pharmacy Management

- Complete inventory management (medicines, stock, purchase, sale)
- Customer & prescription records
- Invoice / sale management
- Role-based access (e.g., admin, pharmacist)

### 2. Prescription OCR & BMDC Validation

- Users upload a prescription image (JPEG / PNG / PDF)
- A **Python script** (Tesseract OCR + AI) runs from Laravel via command line
- OCR extracts raw text from the prescription
- AI (via **DeepSeek model on OpenRouter**):
  - Extracts the **BMDC registration number** using patterns
  - Optionally extracts patient name, age, diagnosis, medicines, dosage, etc.
- A **web crawler** fetches doctor details from the official BMDC website using the extracted BMDC number
- The system stores / validates:
  - Doctor name
  - BMDC number
  - Specialization (if available)
  - Other metadata

> **Note:** The BMDC crawler is for educational purposes only. When used in production, ensure you comply with BMDC terms of use and local laws.

### 3. Symptom-based Medicine Suggestion

- User selects / types symptoms
- AI model queries the local **medicine directory** (DB) and suggests possible medicines
- Suggestions are mapped to:
  - Generic name
  - Brand name
  - Strength & dosage form
- AI returns only medicines that exist in the system’s DB (no hallucinated brands)

### 4. AI-Powered Generic Information

- For any selected medicine, AI can:
  - Explain generic details
  - Suggest indications / contraindications
  - Show possible side effects (educational, not medical advice)

---

## 🛠 Tech Stack

- **Backend:** Laravel (PHP)
- **Database:** MySQL
- **Frontend:** Blade / Bootstrap (or your stack)
- **AI API:** DeepSeek model via [OpenRouter](https://openrouter.ai/)
- **OCR:** Tesseract via `pytesseract` (Python)
- **Crawler:** Custom PHP made crawler with regex to access BMDC website
- **Others:** Composer, NPM, GitHub Actions (CI)

---
