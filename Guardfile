guard 'phpunit', :tests_path => 'tests', :cli => '--colors' do
  watch("^src/(.*).php")       { |m| "tests/unit/#{m[1]}Test.php" }
  watch("^tests/(.*)Test.php") { |m| "tests/#{m[1]}Test.php" }
end
