<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bubble Sort Algorithm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            margin: 20px 0;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            border-radius: 4px;
        }
        .result h2 {
            margin-top: 0;
            color: #333;
        }
        .array-display {
            font-family: 'Courier New', monospace;
            background-color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }
        .info {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #2196F3;
        }
        .swap-count {
            font-size: 18px;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔢 Bubble Sort Algorithm</h1>
        
        <div class="info">
            <strong>Instructions:</strong> Enter numbers separated by commas (e.g., 9, 2, 7, 4, 3)
        </div>

        <form method="POST">
            <label for="numbers">Enter Array of Integers:</label>
            <input 
                type="text" 
                id="numbers" 
                name="numbers" 
                placeholder="e.g., 9, 2, 7, 4, 3" 
                required
                value="<?php echo isset($_POST['numbers']) ? htmlspecialchars($_POST['numbers']) : ''; ?>"
            >

            <label for="order">Sort Order:</label>
            <select id="order" name="order">
                <option value="asc" <?php echo (isset($_POST['order']) && $_POST['order'] == 'asc') ? 'selected' : ''; ?>>
                    Ascending (Low to High)
                </option>
                <option value="desc" <?php echo (isset($_POST['order']) && $_POST['order'] == 'desc') ? 'selected' : ''; ?>>
                    Descending (High to Low)
                </option>
            </select>

            <button type="submit">Sort Array</button>
        </form>

        <?php
        /**
         * Bubble Sort Algorithm
         * 
         * This function sorts an array using the bubble sort technique.
         * Bubble sort repeatedly steps through the array, compares adjacent elements,
         * and swaps them if they are in the wrong order.
         * 
         * Algorithm Steps:
         * 1. Compare each pair of adjacent elements
         * 2. Swap them if they're in the wrong order
         * 3. Repeat until no more swaps are needed
         * 
         * Time Complexity: O(n²) - nested loops
         * Space Complexity: O(1) - sorts in place
         * 
         * @param array $arr - The array to sort
         * @param string $order - "asc" for ascending, "desc" for descending
         * @return array - [sorted array, number of swaps performed]
         */
        function bubbleSort($arr, $order = "asc") {
            // Get the length of the array
            $n = count($arr);
            
            // Initialize swap counter to track algorithm efficiency
            $swapCount = 0;
            
            // Outer loop: controls the number of passes through the array
            // We need (n-1) passes to ensure the array is fully sorted
            for ($i = 0; $i < $n - 1; $i++) {
                // Flag to optimize: if no swaps occur, array is already sorted
                $swapped = false;
                
                // Inner loop: compares adjacent elements
                // With each pass, the largest (or smallest) element "bubbles" to the end
                // We can reduce comparisons by ($i) since the last $i elements are already sorted
                for ($j = 0; $j < $n - $i - 1; $j++) {
                    // Determine if we need to swap based on sort order
                    $shouldSwap = false;
                    
                    if ($order == "asc") {
                        // Ascending: swap if current element is greater than next
                        $shouldSwap = ($arr[$j] > $arr[$j + 1]);
                    } else {
                        // Descending: swap if current element is less than next
                        $shouldSwap = ($arr[$j] < $arr[$j + 1]);
                    }
                    
                    // Perform the swap if needed
                    if ($shouldSwap) {
                        // Swap adjacent elements using a temporary variable
                        $temp = $arr[$j];
                        $arr[$j] = $arr[$j + 1];
                        $arr[$j + 1] = $temp;
                        
                        // Increment swap counter
                        $swapCount++;
                        
                        // Mark that a swap occurred in this pass
                        $swapped = true;
                    }
                }
                
                // Optimization: if no swaps occurred in this pass, array is sorted
                if (!$swapped) {
                    break;
                }
            }
            
            // Return both the sorted array and the swap count
            return [$arr, $swapCount];
        }

        // Process form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get user input
            $numbersInput = $_POST['numbers'];
            $order = $_POST['order'];
            
            // Parse the input string into an array
            // Remove spaces and split by comma
            $numbersArray = array_map('trim', explode(',', $numbersInput));
            
            // Convert strings to integers and filter out non-numeric values
            $originalArray = array_filter(array_map('intval', $numbersArray), function($val, $key) use ($numbersArray) {
                return is_numeric($numbersArray[$key]);
            }, ARRAY_FILTER_USE_BOTH);
            
            // Re-index array to ensure sequential keys
            $originalArray = array_values($originalArray);
            
            // Validate that we have at least one number
            if (empty($originalArray)) {
                echo '<div class="result" style="border-left-color: #f44336;">';
                echo '<h2 style="color: #f44336;">❌ Error</h2>';
                echo '<p>Please enter valid numbers separated by commas.</p>';
                echo '</div>';
            } else {
                // Perform bubble sort
                list($sortedArray, $swapCount) = bubbleSort($originalArray, $order);
                
                // Display results
                echo '<div class="result">';
                echo '<h2>✅ Sorting Results</h2>';
                
                echo '<p><strong>Original Array:</strong></p>';
                echo '<div class="array-display">[' . implode(', ', $originalArray) . ']</div>';
                
                echo '<p><strong>Sorted (' . $order . '):</strong></p>';
                echo '<div class="array-display">[' . implode(', ', $sortedArray) . ']</div>';
                
                echo '<p><strong>Performance Metrics:</strong></p>';
                echo '<p class="swap-count">Total Swaps: ' . $swapCount . '</p>';
                echo '<p style="color: #666; font-size: 14px;">Array Size: ' . count($originalArray) . ' elements</p>';
                
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>