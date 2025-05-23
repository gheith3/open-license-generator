# Intelligent Open Source License Recommendation System

---

### 1. Introduction

In the modern era of collaborative software development, open source licenses serve as vital instruments that define the terms under which software can be used, modified, and distributed. Licenses ensure legal protection, promote transparency, and foster community trust. Despite their importance, many developers, especially those new to open source, struggle to choose a license that aligns with their values and project goals.

This project was created to simplify the license selection process for open source developers. It allows users to answer a few structured questions, then automatically suggests the most suitable license based on their answers. This reduces confusion, saves time, and ensures legal clarity for developers and users alike.

---

### 2. Project Objectives

-   To simplify open source license selection through guided user input.
-   To educate users on key licensing concerns (e.g., attribution, commercial use).
-   To enable extensibility through a dynamic, database-driven architecture.
-   To build the application entirely with open source tools and technologies.

---

### 3. System Architecture

#### 3.1 Technologies Used

This application is developed using a modern open source stack:

-   **Laravel 12**: Web framework for backend and routing.
-   **Livewire**: Enables dynamic and reactive components.
-   **Filament**: Admin panel and UI builder for Laravel.
-   **SQLite**: Lightweight database for simplicity and portability.
-   **PHP 8.2** and **Composer**: Programming language and dependency manager.
-   **PHPUnit**: Automated testing framework.

#### 3.2 Database Design

-   `LicenseTemplate`: Stores metadata and full text of licenses.
-   `Question`: Stores each decision-making prompt.
-   `Option`: Possible answers to each question.
-   `OptionLicenseScore`: Scores linking options to license recommendations.
-   `GeneratedLicense`: User-specific license results.

---

### 4. Methodology

#### 4.1 Question Design

The system uses a small set of high-impact questions to evaluate user intent. Each question corresponds to a major licensing principle:

1. Should the software be usable with minimal restrictions?
2. Should derivative works be open sourced?
3. Should users give credit to the original author?
4. Should commercial use be allowed?

Each option (typically “Yes” or “No”) is scored for every license template. This score reflects how well the option aligns with the goals of that license.

#### 4.2 Scoring Algorithm

The system uses a weighted scoring system:

| Question                    | MIT | GPL | Apache |
| --------------------------- | --- | --- | ------ |
| Minimal restrictions        | 3   | 1   | 2      |
| Open source for derivatives | 1   | 3   | 2      |
| Attribution required        | 2   | 3   | 2      |
| Allow commercial use        | 3   | 1   | 3      |

User answers are collected, and scores are summed for each license. The license with the highest total score is recommended.

---

#### 4.3 System Flexibility and Extensibility

A unique feature of this system is its fully dynamic design. The system allows easy addition of new licenses and questions without modifying code:

-   New licenses are added via the `LicenseTemplate` table.
-   New questions and answer options are added via the `Question` and `Option` models.
-   `OptionLicenseScore` links every answer to a license score.

This approach makes it easy to:

-   Expand support for other license families (e.g., BSD, AGPL).
-   Modify or translate questions.
-   Implement more advanced logic in the future.

---

### 5. Results and Contributions

The project offers a practical, user-friendly solution for selecting open source licenses. It:

-   Helps developers avoid legal pitfalls.
-   Serves as an educational tool.
-   Promotes proper licensing in the community.
-   Demonstrates clean, modular software design principles.

Because the project is open source and uses an open stack, it is ready for contribution and localization. Others can add licenses, improve the UI, or localize it to other languages.

---

### 6. Screenshot

![OS1](Screenshots/os1.png)
![OS1](Screenshots/os2.png)
![OS1](Screenshots/os3.png)
![OS1](Screenshots/os4.png)
![OS1](Screenshots/os5.png)
![OS1](Screenshots/os6.png)
![OS1](Screenshots/os7.png)
![OS1](Screenshots/os8.png)
![OS1](Screenshots/os9.png)

---

### 7. Conclusion

The Intelligent Open Source License Recommendation System is an effective and extensible tool designed to help developers make informed licensing decisions. Built entirely with open technologies, it aligns well with the ethos of open source itself. By transforming a complex legal decision into a guided process, the system lowers barriers for developers around the world and promotes sustainable open source practices.
