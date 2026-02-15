import './bootstrap';
const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');
const app = express();

// ======== ADD THIS CORS CODE ========
app.use(cors({
    origin: "http://127.0.0.1:8000",
    credentials: true
}));
app.use(express.json());

// ======== DATABASE CONNECTION ========
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root', // Change if your MySQL user is different
    password: '', // Add your MySQL password if you have one
    database: 'attendance_system' // Change to your database name
});

// Connect to database
db.connect((err) => {
    if (err) {
        console.log('Database connection error:', err);
    } else {
        console.log('✅ Connected to MySQL database');
    }
});

// ======== ATTENDANCE SCAN ROUTE ========
app.post('/attendance/scan/:token', (req, res) => {
    const token = req.params.token;
    console.log('🔍 Scanning token:', token);

    // 1. Check if token exists in database
    const checkTokenQuery = 'SELECT * FROM qr_codes WHERE token = ? AND is_used = 0';
    
    db.query(checkTokenQuery, [token], (err, results) => {
        if (err) {
            console.log('❌ Database error:', err);
            return res.status(500).json({ error: 'Database error' });
        }

        if (results.length === 0) {
            console.log('❌ Invalid or used token');
            return res.status(400).json({ error: 'Invalid or used token' });
        }

        const qrCode = results[0];
        console.log('✅ Valid token found for student:', qrCode.student_id);
        
        // 2. Insert attendance record
        const markAttendanceQuery = 'INSERT INTO attendance (student_id, qr_token, scanned_at) VALUES (?, ?, NOW())';
        
        db.query(markAttendanceQuery, [qrCode.student_id, token], (err, result) => {
            if (err) {
                console.log('❌ Attendance insert error:', err);
                return res.status(500).json({ error: 'Failed to mark attendance' });
            }

            console.log('✅ Attendance inserted, ID:', result.insertId);

            // 3. Mark QR code as used
            const updateTokenQuery = 'UPDATE qr_codes SET is_used = 1 WHERE token = ?';
            db.query(updateTokenQuery, [token], (err) => {
                if (err) {
                    console.log('❌ Token update error:', err);
                    return res.status(500).json({ error: 'Failed to update token' });
                }
                
                console.log('✅ QR code marked as used');
                res.json({ 
                    success: true, 
                    message: 'Attendance marked successfully',
                    studentId: qrCode.student_id 
                });
            });
        });
    });
});

// ======== START SERVER ========
const PORT = 8080;
app.listen(PORT, () => {
    console.log(`🚀 Server running on port ${PORT}`);
    console.log(`📱 Backend URL: http://127.0.0.1:${PORT}`);
});
