guard 'phpunit', :tests_path => 'tests', :cli => '--colors' do
  watch(%r{^src/(.*).php})       { |m| "tests/unit/#{m[1]}Test.php" }
  watch(%r{^tests/(.*)Test.php}) { |m| "tests/#{m[1]}Test.php" }
end
