# Medications App

A PHP and MySQL application that stores and retrieves medication data in a normalized database structure, producing exact JSON output as specified.
## OUTPUT##
<<img width="953" height="539" alt="Screenshot 2025-09-30 190152" src="https://github.com/user-attachments/assets/36fc4814-814e-4ce1-a1de-78e46aa56353" /> 
<img width="955" height="500" alt="vrifyOutput" src="https://github.com/user-attachments/assets/958e7e77-0a67-45da-8717-a4cc76a64643" />
<img width="560" height="413" alt="p2" src="https://github.com/user-attachments/assets/49c5fba1-7a5e-4ec6-a885-09e8f1f03d80" /> 
<img width="957" height="539" alt="actual vs Excpected output" src="https://github.com/user-attachments/assets/61376b21-bffb-4b97-aa51-47f6621604c7" />
<img width="623" height="512" alt="Screenshot 2025-09-30 191842" src="https://github.com/user-attachments/assets/8104de20-f65e-483e-82b6-13549ebb8029" />
<img width="959" height="539" alt="xampp" src="https://github.com/user-attachments/assets/326b8b29-6d3f-44f3-b401-62c9cf2526cb" />










## 🚀 Features

- **MySQL Database Schema** with proper normalization
- **PHP Models** for data management
- **RESTful JSON API** output
- **Exact JSON Structure** matching requirements
- **Step-by-step Verification** process

## 📋 Prerequisites

- XAMPP (Apache + MySQL + PHP)
- Windows OS
- Web Browser

## 🛠 Installation

1. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL**

2. **Clone or Download Project**
   ```bash
   # Place files in htdocs folder
   C:\xampp\htdocs\medications-app\
   ```

3. **Access Application**
   ```
   http://localhost/medications-app/
   ```

## 🗄 Database Schema

The application uses a normalized database structure with 4 tables:

### Tables Structure

1. **medications** - Main medication records
2. **medication_classes** - Medication classification
3. **class_name_groups** - Group names (className, className2)
4. **associated_drugs** - Drug details with types

### Relationships
- medications 1:N medication_classes
- medication_classes 1:N class_name_groups  
- class_name_groups 1:N associated_drugs

## 🎯 Usage Steps

Follow these steps in order:

### Step 1: Create Database
```
http://localhost/medications-app/create_database.php
```
- Creates `medications_db` database
- Sets up all required tables with foreign keys

### Step 2: Store Sample Data
```
http://localhost/medications-app/store_data.php
```
- Inserts sample medication data
- Creates the exact structure matching requirements
- Shows progress of data insertion

### Step 3: Fetch JSON Output
```
http://localhost/medications-app/fetch_data.php
```
- Retrieves data from database
- Outputs exact JSON structure as required
- Uses optimized SQL queries

### Step 4: Verify Exact Match
```
http://localhost/medications-app/verify_output.php
```
- Compares database output with expected JSON
- Shows side-by-side comparison
- Confirms exact match success

## 📊 Expected JSON Output

```json
{
    "medications": [
        {
            "medicationsClasses": [
                {
                    "className": [
                        {
                            "associatedDrug": [
                                {
                                    "name": "asprin",
                                    "dose": "",
                                    "strength": "500 mg"
                                }
                            ],
                            "associatedDrug#2": [
                                {
                                    "name": "somethingElse",
                                    "dose": "",
                                    "strength": "500 mg"
                                }
                            ]
                        }
                    ],
                    "className2": [
                        {
                            "associatedDrug": [
                                {
                                    "name": "asprin",
                                    "dose": "",
                                    "strength": "500 mg"
                                }
                            ],
                            "associatedDrug#2": [
                                {
                                    "name": "somethingElse",
                                    "dose": "",
                                    "strength": "500 mg"
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
}
```

## 🔧 Technical Details

### PHP Features Used
- PDO for database connections
- Prepared statements for security
- Transactions for data integrity
- JSON encoding for API output

### MySQL Features Used
- Foreign key constraints
- Auto-increment primary keys
- Cascade delete
- Proper indexing

### Optimization
- Single database connection
- Efficient JOIN-less queries (optimized for the structure)
- Minimal memory usage
- Proper error handling

## ✅ Verification

The application includes built-in verification that ensures:

1. **Database Structure** matches requirements
2. **Data Integrity** through foreign keys
3. **JSON Output** is identical to specifications
4. **Error Handling** for all operations

## 🐛 Troubleshooting

### Common Issues

1. **"Not Found" Error**
   - Check if files are in `C:\xampp\htdocs\medications-app\`
   - Ensure Apache is running

2. **MySQL Connection Error**
   - Verify MySQL service is started
   - Check XAMPP MySQL credentials

3. **Database Creation Failed**
   - Check if `medications_db` already exists
   - Verify MySQL user permissions

### Error Messages
- **MySQL Connection Failed**: Check XAMPP MySQL service
- **Table Creation Failed**: Database might not exist
- **Data Insertion Failed**: Check foreign key constraints

## 📁 File Structure

```
medications-app/
├── index.php              # Main navigation page
├── create_database.php    # Database setup
├── store_data.php         # Data insertion
├── fetch_data.php         # JSON API output
├── verify_output.php      # Validation and comparison
└── README.md             # This file
```

## 🎨 Code Quality

- **Clean, readable code**
- **Proper commenting**
- **Security best practices**
- **Error handling throughout**
- **Modular design**

## 📝 License

This project is for educational/demonstration purposes.

## 👥 Author

Aakash Kumar

## 🔗 Links

- **Live Demo**: `http://localhost/medications-app/`
- **GitHub**: [Aakashkumar22/MedicationApp](https://github.com/Aakashkumar22/MedicationApp)

---

**Note**: This application demonstrates proper database design, PHP model implementation, and exact JSON output generation as required in the specifications.
